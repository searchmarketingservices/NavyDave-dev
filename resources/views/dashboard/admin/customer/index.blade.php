@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.customer-active, .main-box-navy .left-all-links ul li a:hover {
  background-color: white;
  font-weight: 600;
}

.main-box-navy .left-all-links ul li a.customer-active span,.main-box-navy .left-all-links ul li a:hover span {
  background-color: #2CC374;
}

.main-box-navy .left-all-links ul li a.customer-active span img,.main-box-navy .left-all-links ul li a:hover span img {
  filter: invert(0) hue-rotate(465deg) brightness(10.5);
}
</style>
@section('content')

<div class="col-lg-10">
    <div class="main-calendar-box main-calendar-box-list customers-box">
       <div class="two-things-align">
        <h5>Customers</h5>
        <a href="#" class="t-btn">Add Customer  </a>
       </div>
        <div class="three-things-align">
            <div class="main-search-form">
                <form action="">
                    <input type="search" placeholder="Type here...">
                    <button><img src="assets/images/search.png" alt=""></button>
                </form>
            </div>
            <div class="two-btns-align">
                <a href="#" class="t-btn">Search Customers</a>
                <a href="#" class="t-btn t-btn-gray">Export List</a>
            </div>
        </div>
    </div>
    <div class="main-table-box main-table-box-list">
        <table>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Recent Appointment</th>
                <th>Total Appointments</th>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="person-box">
                        <div class="box">
                            <img src="assets/images/person-01.png" alt="">
                        </div>
                        <div class="box">
                            <h5>Esthera Jackson</h5>
                            <h6>esthera@simmmple.com</h6>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="date-time-box">
                        <h5>someone@gmail.com</h5>
                        <h6>(XX) XXX XXXXXXX</h6>
                    </div>
                </td>
                <td>
                    <div class="day-box">
                        <p>June 27, 2024 7:49 pm</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="pagination-box">
        <ul>
            <li><a href="#">&lt;</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">...</a></li>
            <li><a href="#">9</a></li>
            <li><a href="#">10</a></li>
            <li><a href="#">&gt;</a></li>
        </ul>
    </div>
</div>

    @endsection
