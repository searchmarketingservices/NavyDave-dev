@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.staff-active, .main-box-navy .left-all-links ul li a:hover {
  background-color: white;
  font-weight: 600;
}

.main-box-navy .left-all-links ul li a.staff-active span,.main-box-navy .left-all-links ul li a:hover span {
  background-color: #2CC374;
}

.main-box-navy .left-all-links ul li a.staff-active span img,.main-box-navy .left-all-links ul li a:hover span img {
  filter: invert(0) hue-rotate(465deg) brightness(10.5);
}
</style>
@section('content')
<div class="col-lg-10">
    <div class="main-calendar-box main-calendar-box-list customers-box">
       <div class="two-things-align">
        <h5> Staff Members</h5>
       </div>
        <div class="three-things-align services-box">
            <div class="main-search-form">
                <form action="">
                    <div class="form-align-box">
                            <div class="box">
                                <div class="input-box">
                                    <input type="text" placeholder="Service Name">
                                </div>
                                <div class="select-box">
                                    <select name="Service Category" id="Service Category">
                                        <option value="Service Category">Service Category</option>
                                        <option value="Service Category-01">Service Category-01</option>
                                        <option value="Service Category-02">Service Category-02</option>
                                        <option value="Service Category-03">Service Category-03</option>
                                      </select>
                                </div>
                            </div>
                        <div class="two-btns-align">
                            <a href="#" class="t-btn">Search Serivce</a>
                            <a href="#" class="t-btn t-btn-gray">Export List</a>
                            <a href="#" class="t-btn t-btn-gray">Reset</a>
                            <a href="{{ route('admin.staff.create') }}" class="t-btn t-btn-gray">Create</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div class="main-table-box main-table-box-list services-table">
        <table>
            <tr>
                <th>
                    <div class="align-box">
                        <div class="input-box-check">
                            <input type="checkbox"></div>
                            <p>ID</p>
                    </div>

                </th>
                <th>Service Name</th>
                <th>Category</th>
                <th>Duration</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="{{ asset('assets/images/pencil.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/duplicate.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/calendar-box.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/cross.png') }}" alt=""></a></li>
                        <li><a href="#"><img src="{{ asset('assets/images/delete.png') }}" alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>

            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
                </div>
            </td>
            </tr>
            <tr>
                <td><div class="align-box">
                    <div class="input-box-check">
                        <input type="checkbox"></div>
                        <p>00 </p>
                </div></td>
                <td>Golf Coaching Session</td>
                <td>Uncategorized</td>
                <td>02 Hours</td>
                <td>$0.00</td>
            <td>
                <div class="action-box">
                    <ul>
                        <li><a href="#"><img src="assets/images/pencil.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/duplicate.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/calendar-box.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/cross.png" alt=""></a></li>
                        <li><a href="#"><img src="assets/images/delete.png  " alt=""></a></li>
                    </ul>
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
<script src="assets/js/wow-animate.js"></script>
    <script src="assets/js/lib.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>
    <script type="text/javascript">
        $(document).on('ready', function () {




            wow = new WOW(
                {
                    animateClass: 'animated',
                    offset: 100,
                    callback: function (box) {
                        console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
                    }
                }
            );

            wow.init();


        });

    </script>
