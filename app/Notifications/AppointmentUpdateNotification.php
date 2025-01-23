<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Carbon\Carbon;

class AppointmentUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $appointment;
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    public function toArray($notifiable)
    {
        $appointmentDate = Carbon::parse($this->appointment->appointment_date);
        $availableFrom = Carbon::parse($this->appointment->slot->available_from);
        $availableTo = Carbon::parse($this->appointment->slot->available_to);

        // Set the timezone for the appointment date and slot times
        $timezone = config('app.timezone'); // Get your app timezone from config
        $appointmentDate->setTimezone($timezone);
        $availableFrom->setTimezone($timezone);
        $availableTo->setTimezone($timezone);

        return [
            'title' => 'Appointment Updated Successfully',
            'message' => 'Appointment updated by ' . $this->appointment->user->name . ' for ' . $this->appointment->service->name . ' at ' . $appointmentDate->format('Y-m-d') . ' ' . $availableFrom->format('h:i A') . ' to ' . $availableTo->format('h:i A'),
            'created_at' => now(), // Timestamp of the notification
        ];
    }

    public function toDatabase($notifiable)
    {
        $appointmentDate = Carbon::parse($this->appointment->appointment_date);
        $availableFrom = Carbon::parse($this->appointment->slot->available_from);
        $availableTo = Carbon::parse($this->appointment->slot->available_to);

        // Set the timezone for the appointment date and slot times
        $timezone = config('app.timezone'); // Get your app timezone from config
        $appointmentDate->setTimezone($timezone);
        $availableFrom->setTimezone($timezone);
        $availableTo->setTimezone($timezone);

        return [
            'title' => 'Appointment Updated Successfully',
            'message' => 'Appointment updated by ' . $this->appointment->user->name . ' for ' . $this->appointment->service->name . ' at ' . $appointmentDate->format('Y-m-d') . ' ' . $availableFrom->format('h:i A') . ' to ' . $availableTo->format('h:i A'),
            'created_at' => now(), // Timestamp of the notification
        ];
    }

    public function toBroadcast($notifiable)
    {
        $appointmentDate = Carbon::parse($this->appointment->appointment_date);
        $availableFrom = Carbon::parse($this->appointment->slot->available_from);
        $availableTo = Carbon::parse($this->appointment->slot->available_to);

        // Set the timezone for the appointment date and slot times
        $timezone = config('app.timezone'); // Get your app timezone from config
        $appointmentDate->setTimezone($timezone);
        $availableFrom->setTimezone($timezone);
        $availableTo->setTimezone($timezone);

        return new BroadcastMessage([
            'post' => [
                'title' => 'Appointment Updated Successfully',
                'message' => 'Appointment updated by ' . $this->appointment->user->name . ' for ' . $this->appointment->service->name . ' at ' . $appointmentDate->format('Y-m-d') . ' ' . $availableFrom->format('h:i A') . ' to ' . $availableTo->format('h:i A'),
                'created_at' => now(), // Timestamp of the notification
            ],
        ]);
    }

}