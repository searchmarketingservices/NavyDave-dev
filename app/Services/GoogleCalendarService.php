<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\GoogleCredential;

class GoogleCalendarService
{
    public function createEvent($appointment)
    {
        // Fetch Google credentials from the database
        $credentials = GoogleCredential::first(); // Fetch the first record
        if (!$credentials || !$credentials->access_token) {
            return redirect()->route('auth.google'); // Handle missing credentials
        }


        $client = new Google_Client();

        $client->setClientId($credentials->client_id);
        $client->setClientSecret($credentials->client_secret);
        $client->setAccessToken([
            'access_token' => $credentials->access_token,
            'expires_in' => strtotime($credentials->expires_at) - time(),
            'refresh_token' => $credentials->refresh_token,
        ]);

        // If the token is expired
        if ($client->isAccessTokenExpired()) {
            // Check if a refresh token is available
            if ($credentials->refresh_token) {
                $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
                $newAccessToken = $client->getAccessToken();

                // Update the database with the new access token and expiration time
                $credentials->update([
                    'access_token' => $newAccessToken['access_token'],
                    'expires_at' => now()->addSeconds($newAccessToken['expires_in']),
                ]);
            } else {
                // Redirect to Google authorization if refresh token is missing or expired
                return redirect()->route('auth.google');
            }
        }

        $service = new Google_Service_Calendar($client);

        $appointmentDate = new \DateTime($appointment->appointment_date, new \DateTimeZone('America/Phoenix'));

        // Create the start and end DateTime objects by combining the appointment date with slot times
        $startDateTime = new \DateTime(
            $appointment->appointment_date . ' ' . (new \DateTime($appointment->slot->available_from))->format('H:i:s'),
            new \DateTimeZone('America/Phoenix')
        );
        $endDateTime = new \DateTime(
            $appointment->appointment_date . ' ' . (new \DateTime($appointment->slot->available_to))->format('H:i:s'),
            new \DateTimeZone('America/Phoenix')
        );


        // Create a Google_Service_Calendar_Event object
        $event = new Google_Service_Calendar_Event([
            'summary' => 'Appointment with ' . $appointment->staff->user->name,
            'description' => 'Event Title: ' . $appointment->service->name .
                ' for ' . $appointment->first_name . ' ' . $appointment->last_name .
                ' at ' . (new \DateTime($appointment->slot->available_from))->format('h:i A') .
                ' to ' . (new \DateTime($appointment->slot->available_to))->format('h:i A'),
            'location' => $appointment->location,
            'start' => [
                'dateTime' => $startDateTime->format(DATE_ISO8601),
                'timeZone' => 'America/Phoenix',
            ],
            'end' => [
                'dateTime' => $endDateTime->format(DATE_ISO8601),
                'timeZone' => 'America/Phoenix',
            ],
            'attendees' => [
                ['email' => $appointment->email], // User's email
                ['email' => $appointment->staff->user->email], // Staff email
            ],
            'organizer' => [
                'email' => "navydavegolfmail@gmail.com", // Organizer's email (staff's email in this case)
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [['method' => 'popup', 'minutes' => 10]],
            ],
        ]);

        try {
            $calendarId = 'primary';  // 'primary' for the user's main calendar
            $result = $service->events->insert($calendarId, $event, ['sendUpdates' => 'all']);
            \Log::info('Google Calendar event created:', ['event_id' => $result->getId()]);
            $appointment2 = Appointment::find($appointment->id);
            $appointment2->google_event_id = $result->getId();
            $appointment2->save();
            return response()->json(['success' => true, 'message' => 'Event created successfully']);
        } catch (\Exception $e) {
            \Log::error('Google Calendar event creation failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateEvent($appointment)
    {
        // Fetch Google credentials from the database
        $credentials = GoogleCredential::first();
        if (!$credentials || !$credentials->access_token) {
            return redirect()->route('auth.google'); // Handle missing credentials
        }

        $client = new Google_Client();
        $client->setClientId($credentials->client_id);
        $client->setClientSecret($credentials->client_secret);
        $client->setAccessToken([
            'access_token' => $credentials->access_token,
            'expires_in' => strtotime($credentials->expires_at) - time(),
            'refresh_token' => $credentials->refresh_token,
        ]);

        // If the token is expired
        if ($client->isAccessTokenExpired()) {
            if ($credentials->refresh_token) {
                $client->fetchAccessTokenWithRefreshToken($credentials->refresh_token);
                $newAccessToken = $client->getAccessToken();

                // Update the database with the new access token and expiration time
                $credentials->update([
                    'access_token' => $newAccessToken['access_token'],
                    'expires_at' => now()->addSeconds($newAccessToken['expires_in']),
                ]);
            } else {
                return redirect()->route('auth.google');
            }
        }

        $service = new Google_Service_Calendar($client);

        // Fetch appointment date and time
        $startDateTime = new \DateTime(
            $appointment->appointment_date . ' ' . (new \DateTime($appointment->slot->available_from))->format('H:i:s'),
            new \DateTimeZone('America/Phoenix')
        );
        $endDateTime = new \DateTime(
            $appointment->appointment_date . ' ' . (new \DateTime($appointment->slot->available_to))->format('H:i:s'),
            new \DateTimeZone('America/Phoenix')
        );

        // Update Google Calendar event
        try {
            $calendarId = 'primary'; // 'primary' for the user's main calendar
            $eventId = $appointment->google_event_id; // Fetch the saved event ID from the database

            $event = $service->events->get($calendarId, $eventId);
            $event->setSummary('Updated Appointment with ' . $appointment->staff->user->name);
            $event->setDescription('Updated Event: ' . $appointment->service->name . ' for ' . $appointment->first_name . ' ' . $appointment->last_name);
            $event->setStart(new Google_Service_Calendar_EventDateTime([
                'dateTime' => $startDateTime->format(DATE_ISO8601),
                'timeZone' => 'America/Phoenix',
            ]));
            $event->setEnd(new Google_Service_Calendar_EventDateTime([
                'dateTime' => $endDateTime->format(DATE_ISO8601),
                'timeZone' => 'America/Phoenix',
            ]));

            // Save the updated event
            $updatedEvent = $service->events->update($calendarId, $eventId, $event, ['sendUpdates' => 'all']);
            \Log::info('Google Calendar event updated:', ['event_id' => $updatedEvent->getId()]);

            return response()->json(['success' => true, 'message' => 'Event updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Google Calendar event update failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
