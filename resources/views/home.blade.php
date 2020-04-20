<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!--Bootstarp-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!--Font awsome-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('public/assets/style.css')}}" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script> -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.1.1/jquery.min.js"></script> -->
    <script src="{{asset('public/assets/script.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div class="container">

        <div class="flex-center position-ref full-height">
            <div class="top-right links">
                <a href="{{ url('/currencies') }}">Home</a>
            </div>

            <div class="content">
                <!-- <div class="container"> -->
                    <div class="title m-b-md">
                        <a href="javascript:void(0)" class="btn btn-primary">Assignment </a>

                    </div>


                    <div class="space"></div>
                    <div class="row ">
                        <div class="col-md-6 currency-record">
                            <h4>Converted Indian Rupees to US Dollars Table</h4>
                            <div class="table-responsive">
                                <table id="mytable" class="table table-bordred table-striped">
                                    <thead>
                                        <th>Ruppes</th>
                                        <th>Converted Rupees</th>
                                        <th>Date & Time</th>
                                    </thead>
                                    <tbody>
                                        @if(count($currencies)>0)
                                        @foreach($currencies as $currency)
                                        <tr>
                                            <td>{{ @$currency->rs }} ruppes</td>
                                            <td>{{ @number_format($currency->doller,2) }} dollars</td>
                                            <td>{{ date('Y-m-d h:i A',strtotime(@$currency->created_at)) }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="clearfix"></div>
                                <ul class="pagination pull-right">
                                    {{$currencies->links()}}
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 currency-record">
                            <div class="row flex-center centered-form convert-form">
                                <div class=" col-md-12 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Convert Indian Rupees to US Dollar</small>
                                        </div>
                                        <div class="panel-body">
                                            <form role="form" method="post">
                                                <div class="row">
                                                    <div class="col-md-12 flex-center">
                                                        <div class="form-group">
                                                            <input type="text" name="rs" id="ruppees" class="form-control input-sm number" placeholder="Enter indian rupees" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <a onclick="convert_currency()" class="btn btn-info btn-sm submit-button">Convert</a>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-center centered-form convert-form">
                                <div class=" col-md-12 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Upload CSV File</small>
                                        </div>
                                        <div class="panel-body">
                                            <input type="file" id="fileUpload" />
                                            <input type="button" id="upload" value="Upload" onclick="Upload()" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-center centered-form convert-form">
                                <div class=" col-md-12 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Convert CSV to JSON </small>
                                        </div>
                                        <div class="panel-body">
                                            <input type="file" id="fileUploadCSV" />
                                            <input type="button" id="btnUpload" value="Convert"/>
                                            <hr />
                                            <div id="DivJson">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-center centered-form convert-form">
                                <div class=" col-md-6 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Average Value </small>
                                        </div>
                                        <div class="panel-body">
                                            {{ number_format($average,2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Minimum Value </small>
                                        </div>
                                        <div class="panel-body">
                                            {{ number_format($min,2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Medium Value </small>
                                        </div>
                                        <div class="panel-body">
                                            {{ number_format($med,2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-md-6 conversion-form">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <small class="panel-title">Maximum Value </small>
                                        </div>
                                        <div class="panel-body">
                                            {{ number_format($max,2) }}
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>

                    </div>
                </div>


                <!--Model Popup starts-->
                <div class="modal" id="ignismyModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label=""><span onclick="modalFade()">×</span></button>
                            </div>

                            <div class="modal-body"> 
                                <!-- <div class="thank-you-pop">
                                    <img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
                                    <h1>Success!</h1>
                                    <p>Converted Currency Indian Rupees to US Dollars</p>
                                    <h3 class="cupon-pop">Rupees: <span>52</span></h3><br>
                                    <h3 class="cupon-pop">Dollars: <span>52</span></h3>
                                    <form><input type="text" name="email" id="email" placeholder="example@example.com"><input type="hidden" name="rupees" id="rupees" value="5"><input type="hidden" name="dollar" id="dollars" value="10"><input type="button" onclick="sendMail()" value="Send Mail"></form>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--Model Popup ends-->
            </div>
        </body>
        <script>
            $('.number').keypress(function(event) {
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });
        </script>
        </html>
