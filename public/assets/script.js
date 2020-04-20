var base_url = window.location.pathname;
var host_url = window.location.hostname;
var custom_url = 'http://localhost/assignment';

const formatter = new Intl.NumberFormat('en-US', {
 minimumFractionDigits: 2,      
 maximumFractionDigits: 2,
});

// ===========Convert indian currency to Dollars ========
function convert_currency() {
    var rupees = $('#ruppees').val();
    if(rupees.length == ''){
        var html = '<div class="thank-you-pop"><img src="'+custom_url+'/public/assets/img/cross.png" alt=""><h1>Error!</h1><p>Currnecy field can not be blank.</p></div>';
        $('.modal-body').html(html);
        $('.modal').removeClass('fade');
        $('.modal').addClass('fadein');
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Free Currency conversion Rate APi 
    // $.ajax({
    //     url:"https://prime.exchangerate-api.com/v5/258a9eafbc491b6d1bac282d/latest/USD",
    //     type:"GET",
    //     success: function(result) {
    //         console.log(result);
    //     }
    // });
    var dollars = rupees / 76.50;
    var roundDollar = formatter.format(dollars);
    $.ajax({
        url: base_url,
        type: 'POST',
        dataType: 'json',
        data: {
            rupees: rupees,
            dollars: dollars 
        },        
        success: function(data) {
            if(data > 0){
                var html = '<div class="thank-you-pop"><img src="./public/assets/img/Green-Round-Tick.png" alt=""><h1>Success!</h1><p>Converted Currency Indian Rupees to US Dollars</p><h3 class="cupon-pop">Rupees: <span>'+rupees+'</span></h3><br><h3 class="cupon-pop">Dollars: <span>'+roundDollar+'</span></h3><form><input type="text" name="email" id="email" placeholder="example@example.com"><input type="hidden" name="rupees" id="rupees" value="'+rupees+'"><input type="hidden" name="dollar" id="dollars" value="'+roundDollar+'"><input type="button" onclick="sendMail()" value="Send Mail"></form></div>';
                $('.modal-body').html(html);
                $('.modal').removeClass('fade');
                $('.modal').addClass('fadein');
            }
            else{
                var html = '<div class="thank-you-pop"><img src="./public/assets/img/cross.png" alt=""><h1>Error!</h1><p>Something went wrong.Please try again.</p></div>';
                $('.modal-body').html(html);
                $('.modal').removeClass('fade');
                $('.modal').addClass('fadein');
            }
        },
        // error: function(response) {
        //     console.log(response);
        // }
    })
}
// ===========Modal Fadein ========
function modalFade(){
    $('.modal').removeClass('fadein');
    $('.modal').addClass('fade');
}

// ===========CSV TO JSON ========
$(function () {    
    var csv = $("#fileUploadCSV").val();
    $("#btnUpload").bind("click", function () {
        debugger;
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
        //regex for Checking valid files csv of txt 
        if (regex.test($("#fileUploadCSV").val().toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var rows = e.target.result.split("\r\n");

                    if(rows.length>0){
                        var first_Row_Cells = splitCSVtoCells(rows[0], ","); //Taking Headings
                        var jsonArray = new Array();
                        for(var i=1;i<rows.length;i++)
                        {
                            var cells = splitCSVtoCells(rows[i], ",");                                                   
                            var obj = {};
                            for(var j=0;j<cells.length;j++)
                            {
                                obj[first_Row_Cells[j]] = cells[j];
                            }
                            jsonArray.push(obj);
                        }
                        //Converting to json and json string to div
                        $("#DivJson").html(JSON.stringify(jsonArray));
                    }
                }
                reader.readAsText($("#fileUploadCSV")[0].files[0]);
            } 
            else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Select a valid CSV File.");
        }
    });
});

function splitCSVtoCells(row, separator) {
    return row.split(separator);
}

// ========Upload CSV File=========
function Upload() {
    var fileUpload = document.getElementById("fileUpload");
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/;
    if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (FileReader) != "undefined") {
            var reader = new FileReader();
            reader.onload = function (e) {
                var table = document.createElement("table");
                var rows = e.target.result.split("\n");
                for (var i = 0; i < rows.length; i++) {
                    var cells = rows[i].split(",");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    if(isNaN(cells[0]) == false && cells[0] != ''){
                        var dollars = cells[0] / 76.50;
                        var roundDollar = formatter.format(dollars);
                        $.ajax({
                            url: base_url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                rupees: cells[0],
                                dollars: dollars 
                            },        
                            success: function(data) {
                                if(data > 0){
                                    var html = '<div class="thank-you-pop"><img src="./public/assets/img/Green-Round-Tick.png" alt=""><h1>Success!</h1><p>CSV File uploaded successfully</p></div>';
                                    $('.modal-body').html(html);
                                    $('.modal').removeClass('fade');
                                    $('.modal').addClass('fadein');
                                }
                                else{
                                    var html = '<div class="thank-you-pop"><img src="./public/assets/img/cross.png" alt=""><h1>Error!</h1><p>Something went wrong.Please try again.</p></div>';
                                    $('.modal-body').html(html);
                                    $('.modal').removeClass('fade');
                                    $('.modal').addClass('fadein');
                                }
                            },
                        })
                    }
                }

                // var dvCSV = document.getElementById("dvCSV");
                // dvCSV.innerHTML = "";
                // dvCSV.appendChild(table);
            }
            reader.readAsText(fileUpload.files[0]);
        } else {
            alert("This browser does not support HTML5.");
        }
    } else {
        alert("Please upload a valid CSV file.");
    }
}
// ==========Send Mail==============

function sendMail() {
    var mail = $('#email').val();
    var rupees = $('#rupees').val();
    var dollars = $('#dollars').val();
    if(mail != ''){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: base_url+"/send-mail",
            type: 'POST',
            dataType: 'json',
            data: {
                email: mail,
                rupees: rupees,
                dollars: dollars 
            },        
            success: function(data) {
                // if(data > 0){
                    var html = '<div class="thank-you-pop"><img src="./public/assets/img/Green-Round-Tick.png" alt=""><h1>Success!</h1><p>Mail Send successfully.</p></div>';
                    $('.modal-body').html(html);
                    $('.modal').removeClass('fade');
                    $('.modal').addClass('fadein');
                // }
                // else{
                //     var html = '<div class="thank-you-pop"><img src="./public/assets/img/cross.png" alt=""><h1>Error!</h1><p>Something went wrong.Please try again.</p></div>';
                //     $('.modal-body').html(html);
                //     $('.modal').removeClass('fade');
                //     $('.modal').addClass('fadein');
                // }
            },

        })
    }
    else{
        alert('Email field is required.');
        return false;
    }
}

