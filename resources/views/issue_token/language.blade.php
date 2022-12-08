@extends('layout.call_page')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/custom/keypad.css') }}">
    <style>
        @media print {
            .noprint {
                display: none !important;
            }

            #printSection {
                display: block !important;
            }
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN: Page Main-->
    <div id="loader-wrapper" class="noprint">
        <div id="loader" class="noprint"></div>

        <div class="loader-section section-left noprint"></div>
        <div class="loader-section section-right noprint"></div>

    </div>
    <div id="main" class="noprint" style="padding: 15px 15px 0px;">
        <div class="wrapper">
            <section class="content-wrapper noprint">
                <div class="container noprint">
                    <div class="row">
                        <div class="col s12">
                            <div class="card" style="background:#f9f9f9;box-shadow:none" id="service-btn-container">
                                <span class="card-title"
                                      style="line-height:1;font-size:22px"> {{__('messages.issue_token.select language')}}</span>
                                <div class="divider" style="margin:10px 0 10px 0"></div>

                                <div class="row noprint">
                                    <div class="col s12 m6 mb-3 noprint"
                                         onclick="localStorage.setItem('lang','en-us'); window.location.href = '{{route('issue_token',['en-us'])}}'">
                                            <span class="btn btn-large btn-queue mb-1 width-100 noprint"
                                                  id="service_id_24"
                                                  style="background: #016B3F; height: 100px !important; line-height: 100px; font-size: 25px; font-weight: bold; text-transform: uppercase">English</span>
                                    </div>

                                    <div class="col s12 m6 mb-3 noprint"
                                         onclick="localStorage.setItem('lang','ar'); window.location.href = '{{route('issue_token',['ar'])}}'">
                                            <span class="btn btn-large btn-queue mb-1 width-100 noprint"
                                                  id="service_id_24"
                                                  style="background: #016B3F; height: 100px !important; line-height: 100px; font-size: 25px; font-weight: bold; text-transform: uppercase">Arabic</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{route('create-token')}}" method="post" id="my-form-two" style="display: none;">
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <!-- Modal Structure -->
        <div id="modal1" class="modal modal1  noprint">
            <div class="row align-items-center  noprint">
                <div class="col s12 m6">
                    <h1 style="text-align: center; margin-top: 10px; color: black">Enter Phone Number</h1>
                </div>
                <div class="col s12 m6 right-align">
                    <button style="margin-top: 10px; background: red" class="btn btn-floating"><i
                                class="material-icons" id="close">close</i></button>
                </div>
            </div>
            <div class="result  noprint">
                <input id="mynumber" placeholder="0"/>
            </div>
            <div class="container  noprint">
                <ul class="keypad">
                    <a href="#" class="press" id="1">
                        <li class="button">
                            <p class="number">1</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="2">
                        <li class="button">
                            <p class="number">2</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="3">
                        <li class="button">
                            <p class="number">3</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="4">
                        <li class="button">
                            <p class="number">4</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="5">
                        <li class="button">
                            <p class="number">5</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="6">
                        <li class="button">
                            <p class="number">6</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="7">
                        <li class="button">
                            <p class="number">7</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="8">
                        <li class="button">
                            <p class="number">8</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="9">
                        <li class="button">
                            <p class="number">9</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="DEL">
                        <li class="button clear">
                            <p class="number">DEL</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="0">
                        <li class="button">
                            <p class="number">0</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                    <a href="#" class="press" id="GO">
                        <li class="button go">
                            <p class="number">OK</p>
                        </li>
                        <div class="clearfix"></div>
                    </a>
                </ul>
            </div>
        </div>
    </div>
@endsection
<div id="printSection" style="text-align:center;margin-top: 20px; display:none">
</div>
@section('js')
    <script>
        $(document).ready(function () {
            $('body').addClass('loaded');
            $('.modal').modal({
                dismissible: false
            });
        })
        var service;

        function queueDept(value) {
            if (value.ask_email == 1 || value.ask_name == 1 || value.ask_phone == 1) {
                if (value.ask_email == 1) $('#email_tab').show();
                else $('#email_tab').hide();
                if (value.ask_name == 1) $('#name_tab').show();
                else $('#name_tab').hide();
                if (value.ask_phone == 1) $('#phone_tab').show();
                else $('#phone_tab').hide()
                service = value;
                $('#modal_button').removeAttr('disabled');
                $('#modal1').modal('open');
            } else {
                $('body').removeClass('loaded');
                let data = {
                    service_id: value.id,
                    with_details: false
                }
                createToken(data);
            }
        }

        function issueToken() {
            $('#details_form').validate({
                rules: {
                    name: {
                        required: function (element) {
                            return service.name_required == "1";
                        },
                    },
                    email: {
                        required: function (element) {
                            return service.email_required == "1";
                        },
                        email: true
                    },
                    phone: {
                        required: function (element) {
                            return service.phone_required == "1";
                        },
                        number: true
                    },
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    $('#modal_button').attr('disabled', 'disabled');
                    $('body').removeClass('loaded');
                    let data = {
                        service_id: service.id,
                        name: $('#name').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        with_details: true
                    }
                    createToken(data);
                }
            });
        }

        function createToken(data) {
            $.ajax({
                type: "POST",
                url: "{{route('create-token')}}",
                data: data,
                cache: false,
                success: function (response) {
                    if (response.status_code == 200) {
                        $('#modal1').modal('close');
                        $('#phone').val(null);
                        $('#email').val(null);
                        $('#name').val(null);
                        let html = `
                        <table style="width: 100%;">
                                <tr><th colspan="3" style="text-align:center ;font-weight:bold;font-size: 30px;" id="duplicate"></th></tr>
                                <tr><th colspan="3" style="text-align:center ;font-weight:bold;font-size: 16px;"><img style="max-width: 200px;" src="{{asset('app-assets/images/logo/kush_bank_logo.png')}}" style=""/></th></tr>
                                <tr><th colspan="3" style="text-align:center ;font-weight:bold;font-size: 22px;">` + response.settings.name + `</th></tr>
                                <!--<tr><td colspan="3" style="text-align:center;font-size: 16px;font-weight: bold;">KITALE</td></tr>-->
                                <!--<tr><td colspan="3" style="text-align:center;">Embakasi, Along Catherine Ndoroba Rd/AA Rd Next to AA Hqs.</td></tr>-->
                                <tr><td colspan="3" style="text-align:center;">` + response.settings.location + `</td></tr>
                                <!--<tr><td colspan="3" style="text-align:center;">PIN: P0511615251 Tel: 0724484335</td></tr>-->
                                <!--<tr><td colspan="3" style="text-align:center;"><i><small>Dealers in: Airtime distribution and general supplies..</small></i></td></tr>-->
                                <tr><td colspan="3" style="text-align:center;"><i><small>Tel: ` + response.settings.phone + `</small></i></td></tr>
                                <tr><td colspan="3" style="text-align:center;"><br/></td></tr>
                                <tr><td colspan="3" style="text-align:center;">Service: ` + response.queue.service.name + `</td></tr>
                                <tr><th colspan="3" style="text-align:center ;font-weight:bold;font-size: 22px;">Ticket: ` + response.queue.letter + ` - ` + response.queue.number + `</th></tr>
                                <tr><td colspan="3" style="text-align:center;">Date: ` + response.queue.formated_date + `</td></tr>
                                <tr><td colspan="3" style="text-align:center;"><br/></td></tr>
                                <tr><td colspan="3" style="text-align:center;">Please take your seat we will attain you soon</td></tr>
                                <tr><td colspan="3" style="text-align:center;">{{__('messages.issue_token.customer waiting')}}:` + response.customer_waiting + `</td></tr>
                            </table>`;
                        $('#printSection').html(html);
                        $('body').addClass('loaded');

                        // window.print();
                        printTicket();
                    } else if (response.status_code == 422 && response.errors && (response.errors['name'] || response.errors['email'] || response.errors['phone'])) {
                        $('#modal_button').removeAttr('disabled');
                        if (response.errors['name'] && response.errors['name'][0]) {
                            $('.name').html('<span class="text-danger errbk">' + response.errors['name'][0] + '</span>')
                        }
                        if (response.errors['email'] && response.errors['email'][0]) {
                            $('.email').html('<span class="text-danger errbk">' + response.errors['email'][0] + '</span>')
                        }
                        if (response.errors['phone'] && response.errors['phone'][0]) {
                            $('.phone').html('<span class="text-danger errbk">' + response.errors['phone'][0] + '</span>')
                        }
                        $('body').addClass('loaded');
                    } else {
                        $('#modal1').modal('close');
                        $('#phone').val(null);
                        $('#email').val(null);
                        $('#name').val(null);
                        $('body').addClass('loaded');
                        M.toast({
                            html: 'something went wrong',
                            classes: "toast-error"
                        });
                    }
                },
                error: function () {
                    $('body').addClass('loaded');
                    $('#modal1').modal('close');
                    M.toast({
                        html: 'something went wrong',
                        classes: "toast-error"
                    });
                }
            });
        }

        function printTicket() {
            var mywindow = window.open('', 'PRINT', 'height=600,width=12000');

            mywindow.document.write(document.getElementById('printSection').innerHTML);
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        }

        $('input').mousedown(function (e) {
            e.preventDefault();
            $(this).blur();
            return false;
        });
        var flag = false;
        $(".press").bind('touchstart click', function (event) {
            if (!flag) {
                flag = true;
                setTimeout(function () {
                    flag = false;
                }, 100);
                event.preventDefault();
                var input = $(this).attr('id');
                var existing = $("#mynumber").val();
                var result;
                if (input === "GO") {
                    /* do something with*/
                    if ($("#mynumber").val().length == 10) {
                        let data = {
                            service_id: service.id,
                            name: $('#name').val(),
                            email: $('#email').val(),
                            phone: $("#mynumber").val(),
                            with_details: true
                        }
                        createToken(data);
                        $("#mynumber").val('');
                    }
                } else if (input === "DEL") {
                    result = existing.slice(0, -1);
                    $("#mynumber").val(result);
                } else {
                    if ($("#mynumber").val().length == 10) {
                    } else {
                        existing = $("#mynumber").val();
                        result = existing + input;
                        $("#mynumber").val(result);
                    }
                }
            }

            return false
        });

        $('#close').on('click', function () {
            $('#modal1').modal('close');
            $("#mynumber").val('');
        })
    </script>
@endsection()