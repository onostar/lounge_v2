window.onscroll = function(){changeHeader(), displayTotopButton(), /* displayBooking(), showServices(),*/ displayAbout(),displayPartners(), displaytestimony() /*showRecentWork(), displayCallToAction() */};

/* change header */
/* function changeHeader(){
    if(document.body.scrollTop > 35 || document.documentElement.scrollTop > 35){
        document.getElementById('mainHeader').className = 'new_header';
        // document.getElementById("logos").innerHTML = "<img src='images/logo2.png' alt='marzbee hotels & lounge'>";
        document.getElementById('h1').style.width = '15%';
        document.querySelector('.logo').className = 'new-logo';
    }
    else{
        document.getElementById('mainHeader').className = 'main_header';
        document.getElementById('h1').style.width = '25%';
        document.querySelector('.logo').className = 'logo';
        // document.getElementById("logos").innerHTML = "<img src='images/logo.png' alt='marzbee hotels & lounge'>";
    }
} */

/* show services */
function showServices(){
    if(document.body.scrollTop > 1400 || document.documentElement.scrollTop > 1400){
        document.getElementById('why_choose').style.display= 'flex';
        
    }
    else{
        document.getElementById('why_choose').style.display= 'none';
        
    }
}
/* show request form */
function requestForm(){
    if(document.body.scrollTop > 100 || document.documentElement.scrollTop > 100){
        document.getElementById('reqMaster').style.display= 'block';
        
    }
    else{
        document.getElementById('reqMaster').style.display= 'none';
        
    }
}

/* loader */
/* let loader = document.querySelector('.loading');
let main = document.querySelector('.main');

function init(){
    setTimeout(function() {
        loader.style.opacity = 0;
        loader.style.display = 'none';
        
        main.style.display = 'block';
        setTimeout(()=>{
        main.style.opacity = 1;
        }, 50);
    }, 2500);
}
init(); */

//display to top button after few seconds
function displayTotopButton(){
    if(document.body.scrollTop > 70 || document.documentElement.scrollTop > 70){
        document.querySelector('.toTop').style.display = 'block';
    }
    else{
        document.querySelector('.toTop').style.display = 'none';
    }
}

/* display mobile navigation */
function displayMenu(){
    let myMenu = document.getElementById('navigation');
    if(myMenu.style.display === "block"){
        myMenu.style.display = "none";
        
    }
    else{
        myMenu.style.display = "block";
        
    }
}

/* display request form */
$(document).ready(function(){
    $(".showRequest").click(function(){
        $("#request_form").show();
    })
})
/* close request form */
$(document).ready(function(){
    $("#close_request").click(function(){
        $("#request_form").hide();
    })
})

/* display booking */
function displayBooking(){
    if(document.body.scrollTop > 200 || document.documentElement.scrollTop > 200){
        document.getElementById('bookings').style.display = 'block';
    }else{
        document.getElementById('bookings').style.display = 'none';
    }
}
/* display about */
function displayAbout(){
    if(document.body.scrollTop > 300 || document.documentElement.scrollTop > 300){
        document.getElementById('about_us').style.display = 'flex';
    }else{
        document.getElementById('about_us').style.display = 'none';
    }
}
/* display call to action */
function displayPartners(){
    if(document.body.scrollTop >3500 || document.documentElement.scrollTop > 3500){
        document.querySelector('.partners').style.display = 'flex';
    }else{
        document.querySelector('.partners').style.display = 'none';
    }
}
/* display testimony */
function displaytestimony(){
    if(document.body.scrollTop > 2500 || document.documentElement.scrollTop > 2500){
        document.getElementById('testimonies').style.display = 'block';
    }else{
        document.getElementById('testimonies').style.display = 'none';
    }
}

/* new way to toggle different menu on the page */
function showPage(page){
    //hide all pages when one displays
    document.getElementById("dashboard").style.display = "none";
    $("#nav2Menu").hide();

    document.querySelectorAll('.displays').forEach(div =>{
        div.style.display = "none";
    });
    document.querySelectorAll('.management').forEach(div =>{
        div.style.display = "none";
    });
    document.querySelector(`#${page}`).style.display = "block";
}
//make links clickable to get to its respective page
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".page_navs").forEach(navs => {
        navs.onclick = function(){
            showPage(this.dataset.page);
            $("#paid_receipt").hide();
            document.getElementById("profit").style.display = "none";
            
        }
    })
})

// display login on mobile
$(document).ready(function(){
    $("#mobile_log #loginDiv").click(function(){
        $("#mobile_log .login_option").toggle();
        // console.log("Working");
    }); 
});

$(document).ready(function(){
    $(".menu_icon").click(function(){
        $(".mobile_menu").toggle();
    });
    $("#contents").click(function(){
        $(".mobile_menu").hide();
        
    })
})

//display login on desktop page
$(document).ready(function(){
    $("#loginDiv").click(function(){
        $(".login_option").toggle();
        // alert("work");
    });
    
});

/* calaculate currency rate for deposit without refresh*/
$(document).ready(function(){
    $("#deposit").click(function(){
        let currency = document.getElementById("currency").value;
        let plan = document.getElementById("plan").value;
        let amount = document.getElementById("amount").value;
        let user_id = document.getElementById("user_id").value;
        // alert(plan);
        $.ajax({
            type : "POST",
            url : "../controller/confirm_deposit.php",
            data : {currency:currency, plan:plan, amount:amount, user_id:user_id},
            success : function(response){
                $("#confirm_deposit").html(response);
            }
        })
        $("#invest").hide();
        $("#confirm_deposit").show();
        return false;
    })
})
/* calaculate currency rate for withdrawal without refresh*/
$(document).ready(function(){
    $("#withdraw").click(function(){
        let with_currency = document.getElementById("with_currency").value;
        let with_amount = document.getElementById("with_amount").value;
        let with_user_id = document.getElementById("with_user_id").value;
        let wallet = document.getElementById("wallet").value;
        // alert(plan);
        $.ajax({
            type : "POST",
            url : "../controller/confirm_withdraw.php",
            data : {with_currency:with_currency, with_amount:with_amount, with_user_id:with_user_id, wallet:wallet},
            success : function(response){
                $("#confirm_withdrawal").html(response);
            }
        })
        $("#withdrawal").hide();
        $("#confirm_withdrawal").show();
        return false;
    })
})
/* search deposits by date */
$(document).ready(function(){
    $("#search_date").click(function(){
        let from = document.getElementById("from").value;
        let to = document.getElementById("to").value;
        
        $.ajax({
            type : "POST",
            url : "../controller/search_deposits.php",
            data : {from:from, to:to},
            success : function(response){
                $(".current_search").html(response);
            }
        })
        
        return false;
    })
})
/* SEARCH deposits by date for users */
$(document).ready(function(){
    $("#user_search_date").click(function(){
        let user_from = document.getElementById("user_from").value;
        let user_to = document.getElementById("user_to").value;
        let user_id_date = document.getElementById("user_id_date").value;
        
        $.ajax({
            type : "POST",
            url : "../controller/search_user_deposits.php",
            data : {user_from:user_from, user_to:user_to, user_id_date:user_id_date},
            success : function(response){
                $(".current_search").html(response);
            }
        })
        
        return false;
    })
})
/* view articles / news */
function viewArticle(article){
    window.open("article.php?article="+article, "_parent");
    return;
}
/* view user */
function showUser(user_id){
    window.open("admin.php?user="+user_id, "_parent");
    return;
}
/* search users */
$(document).ready(function(){
    let $row = $('#user_table tbody tr');
    $('#searchUsers').keyup(function() {
        let val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $row.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
})
/* search currencies */
$(document).ready(function(){
    let $row = $('#cur_table tbody tr');
    $('#searchCurrency').keyup(function() {
        let val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $row.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
})
/* search deposit to approve */
$(document).ready(function(){
    let $row = $('#app_table tbody tr');
    $('#searchApp').keyup(function() {
        let val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $row.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
})
/* search deposit list */
$(document).ready(function(){
    let $row = $('#dep_table tbody tr');
    $('#searchDep').keyup(function() {
        let val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $row.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
})
/* play beep sound */
/* function playBeep(){
    let sound = new Audio('beep-07a.wav');
    sound.autoplay() = true;
    sound.loop = false;
    sound.play();
} */
/* show chat icon after 15 seconds */
setTimeout(function(){
    $("#chat").show();
    // playBeep();
}, 15000);



/* show chat close when chat button clicked */
$(".chat_close").click(function(){
    $(".chat_close").hide();
    $(".chat_icon").show();
    $(".chat_message").hide();
    // playBeep();

})
$(".chat_icon").click(function(){
    $(".chat_icon").hide();
    $(".chat_close").show();
    $(".chat_message").show();
})

/* show first message */
setTimeout(function(){
    $("#chat1").show();
    // playBeep();
}, 20000)
/* show second message */
setTimeout(function(){
    $("#chat2").show();
    // playBeep();

}, 6000)
/* show third message */
setTimeout(function(){
    $("#chat3").show();
    // playBeep();

}, 30000)
/* show plan advert */
setTimeout(function(){
    $(".addverts").show();
    // playBeep();

}, 30000)
/* close adds */
$(document).ready(function(){
    $("#learn").click(function(){
        $(".addverts").hide();
    })
})
$(document).ready(function(){
    $(".close_add").click(function(){
        $(".addverts").hide();
    })
})
/* send dm */
function sendDm(user){
    window.open("send_message.php?user="+user, "_blank");
}
$(document).ready(function(){
    $("#submit_chat").click(function(){
        let recipient = document.getElementById("recipient").value;
        let sender = document.getElementById("sender").value;
        let messages = document.getElementById("messages").value;
        // alert(messages);
        $.ajax({
            type : "POST",
            url : "../controller/send_chat.php",
            data : {recipient:recipient, sender:sender, messages:messages},
            success : function(response){
                $("#chat2").html(response);
            }
        })
        $("#messages").val('');
        return false;
    })
})
/* show edit wallet form */
$(document).ready(function(){
    $("#edit_pen").click(function(){
        $("#wallet_form").show();
    })
})
/* close edit wallet form */
$(document).ready(function(){
    $("#close_wallet").click(function(){
        $("#wallet_form").hide();
    })
})
/* edit wllet */
/* function editWallet(user){
    window.open("controller/edit_wallet.php?user"+user, "_parent");
    return;
} */

/* add currency without refresh */
$(document).ready(function(){
    $("#addCurrency").click(function(){
        let currency = document.getElementById("currency").value;
        let dollar_rate = document.getElementById("dollar_rate").value;
        // alert(currency);
        $.ajax({
            type : "POST",
            url : "../controller/add_currency.php",
            data : {currency:currency, dollar_rate:dollar_rate},
            success : function(response){
                $(".info").html(response);
            }
        })
        $("#currency").val('');
        $("#dollar_rate").val('');
        $("#currency").focus();
        return false;
    })
})

/* nav toggle */
$(document).ready(function(){
    $(".addMenu").click(function(){
        $(".nav2Menu").toggle();
        // $("#nav1Menu").hide();
        // $("#nav3Menu").hide();
        // $("#nav4Menu").hide();
    });
});

//display change price form
function displayPriceForm(form){
    document.querySelectorAll(".priceForm").forEach(forms=>{
        forms.style.display = "none";
    })
    document.querySelector(`#${form}`).style.display = "block";

}
//display price to change for individual item
document.addEventListener("DOMContentLoaded",function(){
    let prices = document.querySelectorAll(".each_prices");
    prices.forEach(price =>{
        price.onclick = function(){
            displayPriceForm(this.dataset.form);
            // console.log(this.dataset.form);
        }
    })
})
//close price form
$(document).ready(function(){
    $(".closeForm").click(function(){
        $(".priceForm").hide();
    })
})
/* change price without refresh */
$(document).ready(function(){
    $("#changePrize").click(function(){
        let item_prize = document.getElementById('item_prize').value;
        
        let item_id = document.getElementById('item_id').value;
        // alert(item_prize);
        $.ajax({
            type: "POST",
            url: "../controller/update_rate.php",
            data: {item_prize:item_prize, item_id:item_id},
            success: function(response){
                $(".each_prices").val(response);
                $(".priceForm").hide();
            }
        })
    return false;
    })
    
})

/* toggle notification messages */
function showNot(note){
    //hide all pages when one displays
    // document.getElementById("dashboard").style.display = "none";
    // $("#nav2Menu").hide();

    document.querySelectorAll('.details').forEach(div =>{
        div.style.display = "none";
    });
    document.querySelector(`#${note}`).style.display = "block";
}
//make links clickable to get to its respective page
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".mess_navs").forEach(navs => {
        navs.onclick = function(){
            showNot(this.dataset.note);
            // $("#paid_receipt").hide();
            // document.getElementById("main_mess").style.display = "none";
            
        }
    })
})

/* approve deosit */
function approveDeposit(dep_id){
    let confirm_dep = confirm("Do you want to approve this deposit?", "");
    if(confirm_dep){
        window.open("../controller/approve_deposit.php?deposit_id="+dep_id, "_parent");
        return;
    }
}
/* get earnings from user select */
$(document).ready(function(){
    $("#user_earn").on("change",function(){
        let user_earn = $(this).val();
        if(user_earn){
        // alert(user_earn);
            
            $.ajax({
                type : "POST",
                url : "../controller/get_earnings.php",
                data : {user_earn:user_earn},
                success: function(response){
                    $(".earning_val").html(response);
                }
            })
            return false;
        }else{
            $(".earning_val").html("<input type='text' value='Select client first'>");
        }
    })
})
/* update earnings without refresh */
$(document).ready(function(){
    $("#update_earnings").click(function(){
        let user_earn = document.getElementById('user_earn').value;
        
        let user_earning = document.getElementById('user_earning').value;
        // alert(user_earning);
        $.ajax({
            type: "POST",
            url: "../controller/update_earnings.php",
            data: {user_earn:user_earn, user_earning:user_earning},
            success: function(response){
                $(".info").html(response);
                // $(".priceForm").hide();
            }
        })
        $("#user_earning").val('');
        return false;
    })
    
})

/* view notification */
function viewMessage(not_id){
    window.open("notifications.php?message="+not_id, "_blank");
    return;
}
/* update chat scroll */
/* function updateScroll() {
    let element = document.querySelector(".all_chat");
    let elementHeight = element.scrollHeight;
    element.scrollTop = elementHeight
} */
// window.onload = updateScroll;
/* change room gallery */
$(document).ready(function(){
    let thumbnails = document.querySelectorAll(".room_thumbnails figure img");
    thumbnails.forEach(function(figures){
        figures.addEventListener("click", function(){
            $("#room_frame").html(figures.cloneNode());
            // $(figures).html(figures);
        })
    })
})

/* submit booking without refresh */
/* $(document).ready(function(){
    $("#book").click(function(){
        let surname = document.getElementById("surname").value;
        let other_names = document.getElementById("other_names").value;
        let phone_number = document.getElementById("phone_number").value;
        let email_address = document.getElementById("email_address").value;
        let home_address = document.getElementById("home_address").value;
        let gender = document.getElementById("gender").value;
        let room_type = document.getElementById("room_type").value;
        let check_in = document.getElementById("check_in").value;
        let check_out = document.getElementById("check_out").value;
        // alert(surname);
        $.ajax({
            type : "POST",
            url : "controller/book_room.php",
            data : {surname:surname, other_names:other_names, phone_number:phone_number, email_address:email_address, home_address:home_address, gender:gender, room_type:room_type, check_in:check_in, check_out:check_out},
            success: function(response){
                $(".successful").html(response);
                
            }

        })
        // $(".successful").show();
        // $("#request_form").hide();
        return false;
    })
}) */

/* close success page */
function closeBooking(){
    document.querySelector(".successful").style.display = "none";
}

/* book room when check availability is clicked */
$(document).ready(function(){
    $("#availability").click(function(){
        $("#request_form").show();
    })
})

/* delete news updates */
function deleteArticle(news){
    let delNews = confirm("Do you want to delete this post?", "");
    if(delNews){
        window.open("../controller/delete_article.php?news="+news, "_parent");
    }
}
/* delete photo */
function deletePhoto(photo){
    let delPhoto = confirm("Do you want to delete this photo?", "");
    if(delPhoto){
        window.open("../controller/delete_photo.php?photo="+photo, "_parent");
    }
}
//get room prices
function getPrice(room){
    let amount;
    let room_fee = document.getElementById("room_fee");
    if(room == "Executive Single"){
        amount = 20000;
        // alert(amount);
    }else if(room == "Executive Standard"){
        amount = 22000;
    }else if(room == "Royal Deluxe"){
        amount = 35000;
    }else if(room == "Supreme Gold"){
        amount = 40000;
    }else{
        amount = 60000;
    }
    room_fee.innerHTML = "<label style='color:red; display:block'>Amount per night</label><input type='text' name='fee' id='fee' value='"+amount+"'>";
}
//calculate days from check in and check out
function calculateDays(){
    let check_in_date = document.getElementById("check_in_date").value;
    let check_out_date = document.getElementById("check_out_date").value; 
    let amount = document.getElementById("amount");
    let fee = document.getElementById("fee").value;
    let num_days = document.getElementById("days");
    firstDay = new Date(check_in_date);
    secondDay = new Date(check_out_date);
    let days = secondDay.getTime() - firstDay.getTime();
    totalDays = days / (1000 * 60 * 60 * 24);
    let newAmount = totalDays * parseInt(fee);
    amount.innerHTML = "<label for='amount_due' style='color:red; display:block'>Amount Due (NGN): </label><input type='text' name='amount_due' id='amount_due' value='"+newAmount+"' readonly style='color:green'>";
    num_days.innerHTML = "<label for='amount_due' style='color:green; display:block'>Checking in for</label><input type='text' style='color:var(--primaryColor);border:none;font-size:1rem' readonly value='"+totalDays+" day(s)'>";
    // alert(check_in_date);
    document.getElementById("book").style.display = "block";
}
// random characters
const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
//generate random characters
function generateString(length) {
    let result = ' ';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}
//online payment and room booking with vpay integration
function roomBooking(){
    // event.preventDefault();
    let fee = document.getElementById("fee").value;
    let total_amount = document.getElementById("total_amount").value;
    let charges = document.getElementById("charges").value;
    let title = document.getElementById("title").value;
    let last_name = document.getElementById("last_name").value;
    let other_names = document.getElementById("other_names").value;
    let phone_number = document.getElementById("phone_number").value;
    let gender = document.getElementById("gender").value;
    let email_address = document.getElementById("email_address").value;
    let home_address = document.getElementById("home_address").value;
    let city = document.getElementById("city").value;
    // let post_code = document.getElementById("post_code").value;
    let country = document.getElementById("country").value;
    // let gender = document.getElementById("gender").value;
    let room_type = document.getElementById("room_type").value;
    let check_in_date = document.getElementById("check_in_date").value;
    let check_out_date = document.getElementById("check_out_date").value;
    let quantity = document.getElementById("quantity").value;
    // let amount_due = document.getElementById("amount_due").value;
    /* let todayDate = new Date();
     let today = todayDate.toLocaleDateString(); */
    transNum = generateString(5)+phone_number;
    if(last_name.length == 0 || last_name.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter last name!");
        $("#last_name").focus();
        return;
    }else if(title.length == 0 || title.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select title!");
        $("#title").focus();
        return;
    }else if(other_names.length == 0 || other_names.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter Other names!");
        $("#other_names").focus();
        return;
    }else if(phone_number.length == 0 || phone_number.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input phone number!");
        $("#phone_number").focus();
        return;
    }else if(email_address.length == 0 || email_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input email address!");
        $("#email_address").focus();
        return;
    }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select gender!");
        $("#gender").focus();
        return;
    }else if(home_address.length == 0 || home_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input residential address!");
        $("#home_address").focus();
        return;
    }else if(room_type.length == 0 || room_type.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select room category!");
        $("#room_type").focus();
        return;
    }else if(city.length == 0 || city.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter city!");
        $("#city").focus();
        return;
    /* }else if(post_code.length == 0 || post_code.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input postal code!");
        $("#post_code").focus();
        return; */
    }else if(country.length == 0 || country.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select country of residence!");
        $("#country").focus();
        return;
   
    }else{
        confirm_booking = confirm("Are you sure you want to confirm this booking", "");
        if(confirm_booking){
            const options = {
                amount: fee,
                currency: 'NGN',
                domain: 'sandbox',
                key: '42639a98-a60f-4d30-a59e-5da0d03227a7',
                email: email_address,
                transactionref: transNum,
                customer_logo: /* 'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg', */'images/logo.png',
                customer_service_channel: '+2347068897068, support@marzbeehotel.com',
                txn_charge: 3,
                txn_charge_type: 'percentage',
                onSuccess: function(response) { 
                $.ajax({
                    type : "POST",
                    url : "controller/book_room.php",
                    data : {fee:fee, total_amount:total_amount, room_type:room_type, quantity:quantity, check_in_date:check_in_date, check_out_date:check_out_date, title:title, last_name:last_name, other_names:other_names, gender:gender, email_address:email_address, phone_number:phone_number, home_address:home_address, city:city, country:country, charges:charges},
                });
                alert('Payment Successful!', response.message);
                window.open("booking.php", "_parent");
                /* document.getElementById("#booking_success").innerHTML = "<p style='color:green; text-align:center; font-size:1.1rem;'>Your payment has been received. Thanks For patronizing Marzbee.<br>Kindly Check your mail for receipt of payment.<br> We look forward to having you <i class='fas fa-thumbs-up'></i></p>"; */
                return;
            },
            onExit: function(response) { console.log('Hello World!',
        response.message); }
        }
        
        if(window.VPayDropin){
            const {open, exit} = VPayDropin.create(options);
            open();                    
        }
        }    
    }            
};

//display exclusive offer
setTimeout(() => {
    $("#exclusive_offer").show();
}, 5000);

//close exclusive offer page
function closeOffer(){
    $("#exclusive_offer").hide();
}

//get airport collection price
function getAirportTariff(){
    let vehicle = document.getElementById("vehicle").value;
    let location = document.getElementById("location").value;
    let destination = document.getElementById("destination").value;
    $.ajax({
        type : "POST",
        url : "admin/controller/get_airport_tariff.php",
        data : {vehicle:vehicle, location:location, destination:destination},
        success : function(response){
            $("#amount_due").html(response);
        }
    })
    return false;
}
//check seats for airport collection
function checkSeat(passenger){
    let seat = document.getElementById("seat").value;
    if(passenger > seat){
        alert("The Vehicle can only accomodate a maximum of "+ seat+" additional pasengers");
        $("#passengers").val('');
        $("#passengers").focus();
    }
}

//get car details
function getCarDetails(car){
    let phone = document.getElementById("phone").value;
    if(!phone){
        alert("Please input phone number");
        $("#phone").focus();
        return;
    }else if(phone.length != 11){
        alert("Pone Number is not correct");
        $("#phone").focus();
        return;
    }else{
        $.ajax({
            type : "POST",
            url : "admin/controller/get_car_details.php",
            data : {car:car, phone:phone},
            success : function(response){
                $("#room_frame").html(response);
                document.getElementById("room_frame").scrollIntoView();
            }
        })
        return false;
    }
}

//get car hire amount
function getHireAmount(){
    let fee = document.getElementById("fee").value;
    let start_date = document.getElementById("start_date").value;
    let return_date = document.getElementById("return_date").value;
    let total_amount = document.getElementById("total_amount");
    let total_days = document.getElementById("total_days");
    let today = new Date();
    firstDay = new Date(start_date);
    secondDay = new Date(return_date);
    if(firstDay < today.setHours(0, 0, 0, 0)){
        alert("Pick-up date cannot be less than current date");
        $("#start_date").focus();
        return;
    }else if(firstDay >= secondDay){
        alert("Pick-up date cannot be greater than return date");
        $("#start_date").focus();
        return;
    }else{
        
        let days = secondDay.getTime() - firstDay.getTime();
        let daysTotal = days / (1000 * 60 * 60 * 24);
        let newAmount = daysTotal * parseInt(fee);
        let charges = newAmount * (3/100);
        total_amount.innerHTML = "<label for='amount_due' style='color:red; display:block'>Amount Due (NGN): </label><input type='text' name='amount_due' id='amount_due' value='"+newAmount+"' readonly style='color:green'><input type='hidden' name='charges' id='charges' value='"+charges+"'>";
        total_days.innerHTML = "<label for='amount_due' style='color:green; display:block'>Hiring for </label><input type='text' style='color:#222;' readonly value='"+daysTotal+" day(s)'><input type='hidden' name='days' id='days' value='"+daysTotal+"'>";
    }

}
//calculate days and total amount  from check in and check out during booking
function calculateBooking(){
    let room_type = document.getElementById("room_type").value;
    let checkin = document.getElementById("checkin").value;
    let checkout = document.getElementById("checkout").value; 
    let room_num = document.getElementById("room_num").value; 
    
    if(checkin == checkout){
         alert("Check in date cannot be same as check out date");
         $("#checkin").focus();
         return;
    }else if(room_type.length == 0 || room_type.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select room category");
         $("#room_type").focus();
         return;
    }else if(room_num.length == 0 || room_num.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please input room quantity");
         $("#room_num").focus();
         return;
    }else{
         // alert(totalDays);
         $.ajax({
              type : "POST",
              url : "controller/check_booking.php",
              data : {checkin:checkin, checkout:checkout, room_num:room_num, room_type:room_type},
              success : function(response){
                   $("#room_availability").html(response);
              }
         })
        //  document.getElementById("check_in_btn").style.display = "block";
         return false;
    }
}
//start booking
function startBooking(event){
    event.preventDefault();
    let room_type = document.getElementById("room_type").value;
    let checkin = document.getElementById("checkin").value;
    let checkout = document.getElementById("checkout").value; 
    let room_num = document.getElementById("room_num").value; 
    let available = document.getElementById("available").value;
    let todayDate = new Date();
    todayDate.setHours(0, 0, 0, 0);
    if (!checkin || !checkout) {
        alert("Please select both check-in and check-out dates.");
        document.getElementById("checkin").focus();
        return;
    }else if(new Date(checkin) >= new Date(checkout)){
         alert("Check in date cannot be greater than or same as check out date");
         document.getElementById("checkin").focus();
         return;
    }else if(new Date(checkin) < todayDate){
        alert("Check in date cannot be lesser than todays date");
        document.getElementById("checkin").focus();
        return;
    }else if(room_type.length == 0 || room_type.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select room category");
         document.getElementById("room_type").focus();

         return;
    }else if(room_num.length == 0 || room_num.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input room quantity");
        document.getElementById("room_num").focus();
        return;
    }else if(available <= 0){
        alert("There are no available rooms of this category for the date selected");
        document.getElementById("room_num").focus();
        return;
    }else if(room_num > available){
        alert("There are only "+available+" rooms available from the category and date selected");
        document.getElementById("room_num").focus();
        return;
    }else{
        document.getElementById("booking_form").submit();
    }
}

//online payment and airport collection booking with vpay integration
function airportCollection(){
    // event.preventDefault();
    let fee = document.getElementById("fee").value;
    let charges = document.getElementById("charges").value;
    let full_name = document.getElementById("full_name").value;
    let phone_number = document.getElementById("phone_number").value;
    let gender = document.getElementById("gender").value;
    let email_address = document.getElementById("email_address").value;
    let address = document.getElementById("address").value;
    let pickup_date = document.getElementById("pickup_date").value;
    let today = new Date();
    let seat = document.getElementById("seat").value;
    let vehicle = document.getElementById("vehicle").value;
    let location = document.getElementById("location").value;
    let destination = document.getElementById("destination").value;
    let passengers = document.getElementById("passengers").value;
    let passenger_names = document.getElementById("passenger_names").value;
    transNum = generateString(5)+phone_number;
    if(passengers > 0){
        if(passenger_names.length == 0 || passenger_names.replace(/^\s+|\s+$/g, "").length == 0){
            alert("Please enter passenger name(s)!");
            $("#passenger_names").focus();
            return;
        }
    }
    if(full_name.length == 0 || full_name.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter full name!");
        $("#full_name").focus();
        return;
    }else if(phone_number.length == 0 || phone_number.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input phone number!");
        $("#phone_number").focus();
        return;
    }else if(email_address.length == 0 || email_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input email address!");
        $("#email_address").focus();
        return;
    }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select gender!");
        $("#gender").focus();
        return;
    }else if(address.length == 0 || address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input pick-up address!");
        $("#address").focus();
        return;
    
    }else if(passengers.length == 0 || passengers.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input passenger!");
        $("#passengers").focus();
        return;
    }else if(pickup_date < today.setHours(0, 0, 0, 0)){
        alert("Pick-up date cannot be lesser than current date");
        $("#passengers").focus();
        windows.open("airport_collection.php#checkin_form", "_parent");
        return;
    }else{
        confirm_booking = confirm("Are you sure you want to confirm this booking", "");
        if(confirm_booking){
            const options = {
                amount: fee,
                currency: 'NGN',
                domain: 'sandbox',
                key: '42639a98-a60f-4d30-a59e-5da0d03227a7',
                email: email_address,
                transactionref: transNum,
                customer_logo: /* 'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg', */'images/logo.png',
                customer_service_channel: '+2347068897068, support@marzbeehotel.com',
                txn_charge: 3,
                txn_charge_type: 'percentage',
                onSuccess: function(response) { 
                    $.ajax({
                        type : "POST",
                        url : "controller/book_collection.php",
                        data : {fee:fee, full_name:full_name, gender:gender, email_address:email_address, phone_number:phone_number, address:address, charges:charges, passenger_names:passenger_names, passengers:passengers, destination:destination, location:location, vehicle:vehicle, seat:seat, pickup_date:pickup_date},
                    });
                    alert('Payment Successful!', response.message);
                    window.open("booking.php", "_parent");
                    return;
                },
            onExit: function(response) { console.log('Hello World!',
        response.message); }
        }
        
        if(window.VPayDropin){
            const {open, exit} = VPayDropin.create(options);
            open();                    
        }
        }    
    }            
};


//online payment for car hire booking with vpay integration
function carBooking(){
    // event.preventDefault();
    let amount_due = document.getElementById("amount_due").value;
    let charges = document.getElementById("charges").value;
    let car = document.getElementById("car").value;
    let fee = document.getElementById("fee").value;
    let full_name = document.getElementById("full_name").value;
    let phone_number = document.getElementById("phone_number").value;
    let gender = document.getElementById("gender").value;
    let email_address = document.getElementById("email_address").value;
    let address = document.getElementById("address").value;
    let start_date = document.getElementById("start_date").value;
    let return_date = document.getElementById("return_date").value;
    let days = document.getElementById("days").value;
    let today = new Date();
    transNum = generateString(5)+phone_number;
    
    if(full_name.length == 0 || full_name.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter full name!");
        $("#full_name").focus();
        return;
    }else if(phone_number.length == 0 || phone_number.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input phone number!");
        $("#phone_number").focus();
        return;
    }else if(email_address.length == 0 || email_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input email address!");
        $("#email_address").focus();
        return;
    }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select gender!");
        $("#gender").focus();
        return;
    }else if(address.length == 0 || address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input pick-up address!");
        $("#address").focus();
        return;
    
    }else if(start_date.length == 0 || start_date.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input pick-up date!");
        $("#start_date").focus();
        return;
    }else if(return_date.length == 0 || return_date.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input return date!");
        $("#return_date").focus();
        return;
    }else if(start_date < today.setHours(0, 0, 0, 0)){
        alert("Pick-up date cannot be lesser than current date");
        $("#start_date").focus();
        // windows.open("complete_car_rental.php#checkin_form", "_parent");
        return;
    }else if(start_date >= return_date){
        alert("Pick-up date cannot be greater or equal to return date");
        $("#start_date").focus();
        return;
    }else{
        confirm_booking = confirm("Are you sure you want to confirm this booking", "");
        if(confirm_booking){
            const options = {
                amount: amount_due,
                currency: 'NGN',
                domain: 'sandbox',
                key: '42639a98-a60f-4d30-a59e-5da0d03227a7',
                email: email_address,
                transactionref: transNum,
                customer_logo: /* 'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg', */'images/logo.png',
                customer_service_channel: '+2347068897068, support@marzbeehotel.com',
                txn_charge: 3,
                txn_charge_type: 'percentage',
                onSuccess: function(response) { 
                    $.ajax({
                        type : "POST",
                        url : "controller/book_car_hire.php",
                        data : {fee:fee, amount_due:amount_due, full_name:full_name, gender:gender, email_address:email_address, phone_number:phone_number, address:address, charges:charges, start_date:start_date, return_date:return_date, car:car, days:days},
                    });
                    alert('Payment Successful!', response.message);
                    window.open("booking.php", "_parent");
                    return;
                },
            onExit: function(response) { console.log('Hello World!',
        response.message); }
        }
        
        if(window.VPayDropin){
            const {open, exit} = VPayDropin.create(options);
            open();                    
        }
        }    
    }            
};

//online payment and lounge booking with vpay integration
function bookTable(){
    // event.preventDefault();
    let fee = document.getElementById("fee").value;
    let charges = document.getElementById("charges").value;
    let total_amount = document.getElementById("total_amount").value;
    let full_name = document.getElementById("full_name").value;
    let phone_number = document.getElementById("phone_number").value;
    let email_address = document.getElementById("email_address").value;
    let book_date = document.getElementById("book_date").value;
    let today = new Date();
    let seats = document.getElementById("seats").value;
    let guests = document.getElementById("guests").value;
    transNum = generateString(5)+phone_number;
    if(seats > 0){
        if(guests.length == 0 || guests.replace(/^\s+|\s+$/g, "").length == 0){
            alert("Please enter additional guest name(s)!");
            $("#guests").focus();
            return;
        }
    }
    if(full_name.length == 0 || full_name.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter full name!");
        $("#full_name").focus();
        return;
    }else if(phone_number.length == 0 || phone_number.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input phone number!");
        $("#phone_number").focus();
        return;
    }else if(email_address.length == 0 || email_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input email address!");
        $("#email_address").focus();
        return;
    }else if(book_date < today.getTime()){
        alert("Book date cannot be lesser than current date");
        $("#full_name").focus();
        windows.open("lounge.php#checkin_form", "_parent");
        return;
    }else{
        confirm_booking = confirm("Are you sure you want to confirm this booking", "");
        if(confirm_booking){
            const options = {
                amount: total_amount,
                currency: 'NGN',
                domain: 'sandbox',
                key: '42639a98-a60f-4d30-a59e-5da0d03227a7',
                email: email_address,
                transactionref: transNum,
                customer_logo: /* 'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg', */'images/logo.png',
                customer_service_channel: '+2347068897068, support@marzbeehotel.com',
                txn_charge: 3,
                txn_charge_type: 'percentage',
                onSuccess: function(response) { 
                    $.ajax({
                        type : "POST",
                        url : "controller/book_table.php",
                        data : {fee:fee, full_name:full_name, email_address:email_address, phone_number:phone_number, charges:charges, guests:guests, total_amount:total_amount, seats:seats, book_date:book_date},
                    });
                    alert('Payment Successful!', response.message);
                    window.open("booking.php", "_parent");
                    return;
                },
            onExit: function(response) { console.log('Hello World!',
        response.message); }
        }
        
        if(window.VPayDropin){
            const {open, exit} = VPayDropin.create(options);
            open();                    
        }
        }    
    }            
};
function displayLoungeMenu(){
    document.getElementById("rest_menu").style.display = "block";
}
function closeMenu(){
    $("#rest_menu").hide();
}


//show item category
function showCategory(category){
    $.ajax({
        type : "GET",
        url : "controller/get_category.php?category="+category,
        beforeSend : function(){
            document.getElementById("menu_items").scrollIntoView();
            $("#menu_items").html("<div class='processing'><div class='loader'></div></div>");
        },
        success : function(response){
            $("#menu_items").html(response);
        }
    })
}
//search menu
function searchMenu(){
    let item = document.getElementById("item").value;
    $.ajax({
        type : "GET",
        url : "controller/search_item.php",
        data : {item:item},
        beforeSend : function(){
            document.getElementById("menu_items").scrollIntoView();
            $("#menu_items").html("<div class='processing'><div class='loader'></div></div>");
        },
        success : function(response){
            $("#menu_items").html(response);
        }
    })
}