
//show mobile menu
function displayMenu(){
     let main_menu = document.getElementById("mobile_log");
     if(window.innerWidth <= "800"){
          $("#menu_icon").click(function(){
               if(main_menu.style.display == "block"){
                    $(".main_menu").hide();
                    $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-bars'></i></a>");
               }else{
                    $(".main_menu").show();
                    $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-close'></i></a>");
               }
          })
               
          
     }
     // else{
          /* $("#menu_icon").click(function(){
               if(main_menu.style.display == "block"){
               alert (window.innerWidth);

                    main_menu.style.display == "none"
                    $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-close'></i></a>");
                    document.getElementById("contents").style.width = "100vw";
                    document.getElementById("contents").style.marginLeft = "0";
               }
          })
     } */
}
displayMenu();
//checck the screen width 
function checkMobile(){
     let screen_width = window.innerWidth;
     if(screen_width <= "800"){
          // alert(screen_width);
          $("#contents").click(function(){
               $(".main_menu").hide();
               $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-bars'></i></a>");
          
          })
     }
}
checkMobile();

// toggle password
function togglePassword(){
    let pw = document.querySelectorAll(".password");
    pw.forEach(ps => {
       if(ps.type === "password"){
            ps.type = "text";
            document.querySelector(".icon").innerHTML = "<i class='fas fa-eye-slash'></i>";
            document.querySelector(".icon_txt").innerHTML = "Hide password";
       }else{
            ps.type = "password";
            document.querySelector(".icon").innerHTML = "<i class='fas fa-eye'></i>";
            document.querySelector(".icon_txt").innerHTML = "Show password";
       } 
    });
}

//toggle logout
$(document).ready(function(){
     $("#loginDiv").click(function(){
          $(".login_option").toggle();
     })
})

//toggle menu with more options
$(document).ready(function(){
     $(".addMenu").click(function(){
          $(".nav1Menu").toggle();
          //change icon from plus to miinus and vice versa
          let option_icon = document.querySelector(".options");
          if(document.querySelector(".nav1Menu").style.display == "block"){
               option_icon.innerHTML = "<i style='background:none; color:#fff!important; box-shadow:none!important;' class='fas fa-minus'></i>";
          }else{
               option_icon.innerHTML = "<i style='background:none; color:#fff!important; box-shadow:none!important;' class='fas fa-plus'></i>";
          }

     })
})
//toggle all submenu
/* show frequenty asked questions */
function toggleMenu(subMenu){
     let menus = document.querySelectorAll(".subMenu");
     menu_id = document.getElementById(subMenu);
     if(menu_id.style.display == "block"){
          menu_id.style.display = "none";
     }else{
          menus.forEach(function(menu){
               menu.style.display = "none";
          })
          menu_id.style.display = "block";
     }
}

//show payment mode forms
function showCash(){
     document.querySelectorAll(".payment_form").forEach(function(forms){
          forms.style.display = "none";
     })
     $("#cash").show();
}
function showPos(){
     document.querySelectorAll(".payment_form").forEach(function(forms){
          forms.style.display = "none";
     })
     $("#pos").show();
}
function showTransfer(){
     document.querySelectorAll(".payment_form").forEach(function(forms){
          forms.style.display = "none";
     })
     $("#transfer").show();
}
//show pages dynamically with xhttp request
function showPage(page){
     let xhr = false;
     if(window.XMLHttpRequest){
          xhr = new XMLHttpRequest();
     }else{
          xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
     if(xhr){
          $(".contents").html("<div class='processing'><div class='loader'></div></div>");
          xhr.onreadystatechange = function(){
               if(xhr.readyState == 4 && xhr.status == 200){
                    document.querySelector(".contents").innerHTML = xhr.responseText;
               }
          }
          xhr.open("GET", page, true );
          xhr.send(null);
     }
}

//add users
function addUser(){
     let username = document.getElementById("username").value;
     let full_name = document.getElementById("full_name").value;
     let user_role = document.getElementById("user_role").value;
     let store_id = document.getElementById("store_id").value;
     // alert(store);
     if(full_name.length == 0 || full_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter user full name!");
          $("#full_name").focus();
          return;
     }else if(username.length == 0 || username.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter a username!");
          $("#username").focus();
          return;
     }else if(user_role.length == 0 || user_role.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select user role!");
          $("#user_role").focus();
          return;
     }else if(store_id.length == 0 || store_id.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select store!");
          $("#store").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_users.php",
               data : {username:username, full_name:full_name, user_role:user_role, store_id:store_id},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#username").val('');
     $("#full_name").val('');
     $("#user_role").val('');
     $("#store").val('');
     $("#full_name").focus();
     return false;
}

//add departments
function addDepartment(){
     let department = document.getElementById("department").value;
     if(department.length == 0 || department.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input department!");
          $("#department").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_department.php",
               data : {department:department},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#department").val('');
     $("#department").focus();
     return false;
}
//add expense head
function addExpHead(){
     let exp_head = document.getElementById("exp_head").value;
     if(exp_head.length == 0 || exp_head.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input expense head!");
          $("#exp_head").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_exp_head.php",
               data : {exp_head:exp_head},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#exp_head").val('');
     $("#exp_head").focus();
     return false;
}
//add categories
function addCategory(){
     let category = document.getElementById("category").value;
     let department = document.getElementById("department").value;
     if(category.length == 0 || category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter category!");
          $("#category").focus();
          return;
     }else if(department.length == 0 || department.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a department!");
          $("#department").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_category.php",
               data : {category:category, department:department},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#category").val('');
     $("#category").focus();
     return false;
}
//add bank
function addBank(){
     let bank = document.getElementById("bank").value;
     let account_num = document.getElementById("account_num").value;
     if(bank.length == 0 || bank.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input bank name!");
          $("#bank").focus();
          return;
     }else if(account_num.length == 0 || account_num.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input account number!");
          $("#account_num").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_bank.php",
               data : {bank:bank, account_num:account_num},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#bank").val('');
     $("#account_num").val('');
     $("#bank").focus();
     return false;
}
//search for data within table
function searchData(data){
     let $row = $(".searchTable tbody tr");
     let val = $.trim(data).replace(/ +/g, ' ').toLowerCase();
     $row.show().filter(function(){
          var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
          return !~text.indexOf(val);
     }).hide();
}

// disale user
function disableUser(user_id){
     let disable = confirm("Do you want to disable this user?", "");
     if(disable){
          // alert(user_id);
          $.ajax({
               type: "GET",
               url : "../controller/disable_user.php?id="+user_id,
               success : function(response){
                    $("#disable_user").html(response);
               }
          })
          setTimeout(function(){
               $('#disable_user').load("disable_user.php #disable_user");
          }, 1000);
          return false;
     }
}

// activate disabled user
function activateUser(user_id){
     let activate = confirm("Do you want to activate this user account?", "");
     if(activate){
          $.ajax({
               type : "GET",
               url : "../controller/activate_user.php?user_id="+user_id,
               success : function(response){
                    $("#activate_user").html(response);
               }
          })
          setTimeout(function(){
               $("#activate_user").load("activate_user.php #activate_user");
          }, 3000);
          return false;
     }
}
// Reset user password
function resetPassword(user_id){
     let reset = confirm("Do you want to reset this user password?", "");
     if(reset){
          $.ajax({
               type : "GET",
               url : "../controller/reset_user_password.php?user_id="+user_id,
               success : function(response){
                    $("#reset_password").html(response);
               }
          })
          setTimeout(function(){
               $("#reset_password").load("reset_password.php #reset_password");
          }, 3000);
          return false;
     }
}

// add items 
function addItem(){
     let department = document.getElementById("department").value;
     let item_category = document.getElementById("item_category").value;
     let item = document.getElementById("item").value;
     // let barcode = document.getElementById("barcode").value;
     if(item_category.length == 0 || item_category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select item category!");
          $("#item_category").focus();
          return;
     }else if(item.length == 0 || item.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter item name");
          $("#item").focus();
          return;
     /* }else if(barcode.length == 0 || barcode.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter item barcode");
          $("#barcode").focus();
          return; */
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_item.php",
               data : {department:department, item_category:item_category, item:item/* , barcode:barcode */},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     // $("#room_category").val('');
     $("#item").val('');
     $("#barcode").val('');
     $("#item").focus();
     return false;    
}
// add stores
function addStore(){
     let store_name = document.getElementById("store_name").value;
     let store_address = document.getElementById("store_address").value;
     let phone = document.getElementById("phone").value;
     if(store_name.length == 0 || store_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter store name!");
          $("#store_name").focus();
          return;
     }else if(store_address.length == 0 || store_address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter store address");
          $("#store_address").focus();
          return;
     }else if(phone.length == 0 || phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter store phone numbers");
          $("#phone").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_store.php",
               data : {store_name:store_name, store_address:store_address, phone:phone},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     // $("#room_category").val('');
     $("#store_name").val('');
     $("#store_address").val('');
     $("#phone").val('');
     $("#store").focus();
     return false;    
}
// add staffs 
function addStaff(){
     let staff_name = document.getElementById("staff_name").value;
     let phone_number = document.getElementById("phone_number").value;
     let home_address = document.getElementById("home_address").value;
     if(staff_name.length == 0 || staff_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input staff name!");
          $("#staff_name").focus();
          return;
     }else if(home_address.length == 0 || home_address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input staff residential address");
          $("#home_address").focus();
          return;
     }else if(phone_number.length == 0 || phone_number.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input staff phone number");
          $("#phone_number").focus();
          return;
     }else if(phone_number.length < 11){
          alert("Phone number is too short");
          $("#phone_number").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_staff.php",
               data : {staff_name:staff_name, phone_number:phone_number, home_address:home_address},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     // $("#room_category").val('');
     $("#staff_name").val('');
     $("#phone_number").val('');
     $("#home_address").val('');
     $("#staff_name").focus();
     return false;    
}
// add suppliers 
function addSupplier(){
     let supplier = document.getElementById("supplier").value;
     let contact_person = document.getElementById("contact_person").value;
     let phone = document.getElementById("phone").value;
     let email = document.getElementById("email").value;
     if(supplier.length == 0 || supplier.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input supplier name!");
          $("#supplier").focus();
          return;
     }else if(contact_person.length == 0 || contact_person.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input contact person name");
          $("#contact_person").focus();
          return;
     }else if(phone.length == 0 || phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input phone number");
          $("#phone").focus();
          return;
     }else if(email.length == 0 || email.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input email address");
          $("#email").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_vendor.php",
               data : {supplier:supplier, contact_person:contact_person, phone:phone, email:email},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#supplier").val('');
     $("#contact_person").val('');
     $("#phone").val('');
     $("#email").val('');
     $("#supplier").focus();
     return false;    
}

// get item categories
function getCategory(post_department){
     let department = post_department;
     if(department){
          $.ajax({
               type : "POST",
               url :"../controller/get_categories.php",
               data : {department:department},
               success : function(response){
                    $("#item_category").html(response);
               }
          })
          return false;
     }else{
          $("#item_category").html("<option value'' selected>Select department first</option>")
     }
     
}


//calculate days from check in and check out
function calculateDays(){
     let check_in_room = document.getElementById("check_in_room").value;
     let check_in_date = document.getElementById("check_in_date").value;
     let check_out_date = document.getElementById("check_out_date").value; 
     let amount = document.getElementById("amount");
     let room_fee = document.getElementById("room_fee").value;
     let num_days = document.getElementById("days");
     let today = new Date();
     if(check_in_date == check_out_date){
          alert("Check in date cannot be same as check out date");
          $("#check_in_date").focus();
          return;
     }else if(check_in_room.length == 0 || check_in_room.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room category");
          $("#check_in_room").focus();
          return;
     }else if(check_in_date < today){
          alert("Check in date cannot be lessa than current date");
          $("#check_in_date").focus();
          return;
     }else{
          firstDay = new Date(check_in_date);
          secondDay = new Date(check_out_date);
          let days = secondDay.getTime() - firstDay.getTime();
          totalDays = days / (1000 * 60 * 60 * 24);
          let newAmount = totalDays * parseInt(room_fee);
          amount.innerHTML = "<label for='amount_due' style='color:#222'>Total Due (NGN): </label><br><input type='text' name='amount_due' id='amount_due' value='"+newAmount+"' readonly style='color:red;border:1px solid #c4c4c4'>";
          num_days.innerHTML = "<label for='amount_due' style='color:#222'>Checking in for</label><br><input type='text' style='font-size:.9rem' readonly value='"+totalDays+" day(s)'>";
          // alert(totalDays);
          document.getElementById("check_in_btn").style.display = "block";
     }
}
//calculate days and otal amount  from check in and check out during booking
function calculateBooking(){
     let check_in_category = document.getElementById("check_in_category").value;
     let check_in_date = document.getElementById("check_in_date").value;
     let check_out_date = document.getElementById("check_out_date").value; 
     let quantity = document.getElementById("quantity").value; 
     let amount = document.getElementById("amount");
     let room_fee = document.getElementById("room_fee").value;
     let num_days = document.getElementById("days");
     if(check_in_date == check_out_date){
          alert("Check in date cannot be ame as check out date");
          $("#check_in_date").focus();
          return;
     }else if(check_in_category.length == 0 || check_in_category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room category");
          $("#check_in_category").focus();
          return;
     }else if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input room quantity");
          $("#quantity").focus();
          return;
     }else{
          firstDay = new Date(check_in_date);
          secondDay = new Date(check_out_date);
          let days = secondDay.getTime() - firstDay.getTime();
          totalDays = days / (1000 * 60 * 60 * 24);
          let newAmount = totalDays * quantity * parseInt(room_fee);
          amount.innerHTML = "<label for='amount_due' style='color:#222'>Total Due (NGN): </label><br><input type='text' name='amount_due' id='amount_due' value='"+newAmount+"' readonly style='color:red;border:1px solid #c4c4c4'>";
          num_days.innerHTML = "<label for='amount_due' style='color:#222'>Checking in for</label><br><input type='text' style='color:red;font-size:.9rem' readonly value='"+totalDays+" day(s)'>";
          // alert(totalDays);
          document.getElementById("check_in_btn").style.display = "block";
          $.ajax({
               type : "POST",
               url : "controller/check_booking.php",
               data : {check_in_category:check_in_category, check_in_date:check_in_date, check_out_date:check_out_date},
               success : function(response){
                    $("#room_availability").html(response);
               }
          })
          return false;
     }
}
//check guest details with phone number
function checkGuest(){
     let guest_phone = document.getElementById("guest_phone").value;
     if(guest_phone.length == 0 || guest_phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("please input guest phone number");
          $("#guest_phone").focus();
          return;
     }else if(guest_phone.length != 11){
          alert("Incorrect phone number format!");
          $("#guest_phone").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "check_in_details.php",
               data : {guest_phone:guest_phone},
               success : function(response){
                    $("#check_in").html(response);
               }
          })
          return false;
     }
}
//check in
function checkIn(){
     let posted_by = document.getElementById("posted_by").value;
     let check_in_category = document.getElementById("check_in_category").value;
     let check_in_room = document.getElementById("check_in_room").value;
     let last_name = document.getElementById("last_name").value;
     let first_name = document.getElementById("first_name").value;
     let emergency_contact = document.getElementById("emergency_contact").value;
     let gender = document.getElementById("gender").value;
    
     let contact_address = document.getElementById("contact_address").value;
     let contact_phone = document.getElementById("contact_phone").value;
     let room_fee = document.getElementById("room_fee").value;
     
     let check_in_date = document.getElementById("check_in_date").value;
     let check_out_date = document.getElementById("check_out_date").value;
     let amount_due = document.getElementById("amount_due").value;
     let todayDate = new Date();
     let today = todayDate.toLocaleDateString();
     // alert(today);
     if(check_in_category.length == 0 || check_in_category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room category!");
          $("#check_in_category").focus();
          return;
     }else if(check_in_room.length == 0 || check_in_room.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room");
          $("#check_in_room").focus();
          return;
     }else if(last_name.length == 0 || last_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Last Name");
          $("#last_name").focus();
          return;
     }else if(first_name.length == 0 || first_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Other Names");
          $("#first_name").focus();
          return;
     }else if(emergency_contact.length == 0 || emergency_contact.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter emergency contact");
          $("#emergency_contact").focus();
          return;
     }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Select Gender");
          $("#gender").focus();
          return;
     
     }else if(contact_address.length == 0 || contact_address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter contact person's Address");
          $("#contact_address").focus();
          return;
     }else if(contact_phone.length == 0 || contact_phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Guest Phone number");
          $("#contact_phone").focus();
          return;
     
     }else if(check_in_date.length == 0 || check_in_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check in date");
          $("#check_in_date").focus();
          return;
     }else if(check_out_date.length == 0 || check_out_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check out date");
          $("#check_out_date").focus();
          return;
     }else if(todayDate > check_in_date){
          alert("Check in date cannot be lesser than todays date");
          $("#check_in_date").focus();
          return;
     }else if(check_in_date >= check_out_date){
          alert("Check in date cannot be greater or equal to check out date");
          $("#check_in_date").focus();
          return;
     }else if(amount_due.length == 0 || amount_due.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room to display amount");
          $("#check_in_room").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/check_in.php",
               data : {posted_by:posted_by,check_in_room:check_in_room, last_name:last_name, first_name:first_name, emergency_contact:emergency_contact, gender:gender,contact_address:contact_address, contact_phone:contact_phone, check_in_date:check_in_date, check_out_date:check_out_date, amount_due:amount_due, room_fee:room_fee},
               success : function(response){
               $("#check_in").html(response);
               }
          })
          setTimeout(() => {
               $("#check_in").load("check_in.php #check_in");
          }, 2000);
          /* $("#check_in_category").val('');
          $("#check_in_room").val('');
          $("#last_name").val('');
          $("#first_name").val('');
          $("#amount_due").val('');
          $("#check_in_date").val('');
          $("#check_out_date").val('');
          $("#age").val('');
          $("#gender").val('');
          $("#days").html('');
          $("#contact_address").val('');
          $("#contact_phone").val('');
          $("#check_in_category").focus(); */
          return false; 
     }
        
}
//add checkin to guest accomodation
function addCheckIn(){
     let posted_by = document.getElementById("posted_by").value;
     let check_in_category = document.getElementById("check_in_category").value;
     let check_in_room = document.getElementById("check_in_room").value;
     let last_name = document.getElementById("last_name").value;
     let first_name = document.getElementById("first_name").value;
     let emergency_contact = document.getElementById("emergency_contact").value;
     let gender = document.getElementById("gender").value;
    let guest = document.getElementById('guest').value;
     let contact_address = document.getElementById("contact_address").value;
     let contact_phone = document.getElementById("contact_phone").value;
     let room_fee = document.getElementById("room_fee").value;
     
     let check_in_date = document.getElementById("check_in_date").value;
     let check_out_date = document.getElementById("check_out_date").value;
     let amount_due = document.getElementById("amount_due").value;
     let todayDate = new Date();
     let today = todayDate.toLocaleDateString();
     // alert(today);
     if(check_in_category.length == 0 || check_in_category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room category!");
          $("#check_in_category").focus();
          return;
     }else if(check_in_room.length == 0 || check_in_room.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room");
          $("#check_in_room").focus();
          return;
     }else if(last_name.length == 0 || last_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Last Name");
          $("#last_name").focus();
          return;
     }else if(first_name.length == 0 || first_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter First Name");
          $("#first_name").focus();
          return;
     }else if(emergency_contact.length == 0 || emergency_contact.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter emergency contact");
          $("#emergency_contact").focus();
          return;
     }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Select Gender");
          $("#gender").focus();
          return;
     
     }else if(contact_address.length == 0 || contact_address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter contact person's Address");
          $("#contact_address").focus();
          return;
     }else if(contact_phone.length == 0 || contact_phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Guest Phone number");
          $("#contact_phone").focus();
          return;
     
     }else if(check_in_date.length == 0 || check_in_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check in date");
          $("#check_in_date").focus();
          return;
     }else if(check_out_date.length == 0 || check_out_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check out date");
          $("#check_out_date").focus();
          return;
     }else if(new Date(today).getTime() > new Date(check_in_date).getTime()){
          alert("Check in date cannot be lesser than todays date");
          $("#check_in_date").focus();
          return;
     }else if((new Date(check_in_date )).getTime() > (new Date(check_out_date)).getTime()){
          alert("Check in date cannot be greater than check out date");
          $("#check_in_date").focus();
          return;
     }else if(amount_due.length == 0 || amount_due.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room to display amount");
          $("#check_in_room").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_check_in.php",
               data : {guest:guest, posted_by:posted_by,check_in_room:check_in_room, last_name:last_name, first_name:first_name, emergency_contact:emergency_contact, gender:gender,contact_address:contact_address, contact_phone:contact_phone, check_in_date:check_in_date, check_out_date:check_out_date, amount_due:amount_due, room_fee:room_fee},
               success : function(response){
               $("#check_in").html(response);
               }
          })
          setTimeout(() => {
               $("#check_in").load("add_accomodation.php?guest="+guest+" #check_in");
          }, 2000);
          /* $("#check_in_category").val('');
          $("#check_in_room").val('');
          $("#last_name").val('');
          $("#first_name").val('');
          $("#amount_due").val('');
          $("#check_in_date").val('');
          $("#check_out_date").val('');
          $("#age").val('');
          $("#gender").val('');
          $("#days").html('');
          $("#contact_address").val('');
          $("#contact_phone").val('');
          $("#check_in_category").focus(); */
          return false; 
     }
        
}
//extend stay
function extendStay(){
     let posted_by = document.getElementById("posted_by").value;
     let guest = document.getElementById("guest").value;
     let check_out_date = document.getElementById("check_out_date").value;
     let amount_due = document.getElementById("amount_due").value;
     let todayDate = new Date();
     let today = todayDate.toLocaleDateString();
     // alert(today);
     
     if(check_out_date.length == 0 || check_out_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check out date");
          $("#check_out_date").focus();
          return;
     }else if(new Date(today).getTime() > new Date(check_out_date).getTime()){
          alert("Check out date cannot be lesser than todays date");
          $("#check_in_date").focus();
          return;
     }else if(amount_due.length == 0 || amount_due.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room to display amount");
          $("#check_in_room").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/extend_stay.php",
               data : {posted_by:posted_by, guest:guest, check_out_date:check_out_date, amount_due:amount_due},
               success : function(response){
               $("#extend_stay").html(response);
               }
          })
          setTimeout(() => {
               $("#extend_stay").load("extend_sstay.php #extend_stay");
          }, 2000);
          /* $("#check_in_category").val('');
          $("#check_in_room").val('');
          $("#last_name").val('');
          $("#first_name").val('');
          $("#amount_due").val('');
          $("#check_in_date").val('');
          $("#check_out_date").val('');
          $("#age").val('');
          $("#gender").val('');
          $("#days").html('');
          $("#contact_address").val('');
          $("#contact_phone").val('');
          $("#check_in_category").focus(); */
          return false; 
     }
        
}

//post other cash payments for guest
function postOtherCash(){
     let posted_by = document.getElementById("posted_by").value;
     let guest = document.getElementById("guest").value;
     let payment_mode = document.getElementById("payment_mode").value;
     let bank_paid = document.getElementById("bank_paid").value;
     let sender = document.getElementById("sender").value;
     let guest_amount = document.getElementById("guest_amount").value;
     let amount_paid = document.getElementById("amount_paid").value;
     
     if(amount_paid.length == 0 || amount_paid.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount paid!");
          $("#amount_paid").focus();
          return;
     // }else if(parseInt(amount_paid) < parseInt(guest_amount)){
     //      alert("Insufficient funds!");
     //      $("#guest_amount").focus();
     //      return;
     }else{
     $.ajax({
          type : "POST",
          url : "../controller/post_other_payments.php",
          data : {posted_by:posted_by, guest:guest, payment_mode:payment_mode, bank_paid:bank_paid, sender:sender, guest_amount:guest_amount, amount_paid:amount_paid},
          success : function(response){
               $("#guest_details").html(response);
          }
     })
          setTimeout(function(){
               $('#guest_details').load("guest_details.php?guest_id=+"+guest + "#guest_details");
          }, 3000);
     }
     return false;    

}
//post other Pos payments for guest
function postOtherPos(){
     let posted_by = document.getElementById("posted_by").value;
     let guest = document.getElementById("guest").value;
     let payment_mode = document.getElementById("pos_mode").value;
     let bank_paid = document.getElementById("pos_bank_paid").value;
     let sender = document.getElementById("sender").value;
     let guest_amount = document.getElementById("guest_amount").value;
     let amount_paid = document.getElementById("pos_amount_paid").value;
     
     if(amount_paid.length == 0 || amount_paid.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount paid!");
          $("#pos_amount_paid").focus();
          return;
     }else if(bank_paid.length == 0 || bank_paid.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select POS Bank!");
          $("#pos_bank_paid").focus();
          return;
     }else{
     $.ajax({
          type : "POST",
          url : "../controller/post_other_payments.php",
          data : {posted_by:posted_by, guest:guest, payment_mode:payment_mode, bank_paid:bank_paid, sender:sender, guest_amount:guest_amount, amount_paid:amount_paid},
          success : function(response){
               $("#guest_details").html(response);
          }
     })
          setTimeout(function(){
               $('#guest_details').load("guest_details.php?guest_id=+"+guest + "#guest_details");
          }, 3000);
     }
     return false;    

}
//post other Transfer payments for guest
function postOtherTransfer(){
     let posted_by = document.getElementById("posted_by").value;
     let guest = document.getElementById("guest").value;
     let payment_mode = document.getElementById("transfer_mode").value;
     let bank_paid = document.getElementById("transfer_bank_paid").value;
     let sender = document.getElementById("transfer_sender").value;
     let guest_amount = document.getElementById("guest_amount").value;
     let amount_paid = document.getElementById("transfer_amount").value;
     
     if(amount_paid.length == 0 || amount_paid.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount paid!");
          $("#transfer_amount").focus();
          return;
     }else if(bank_paid.length == 0 || bank_paid.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select Bank Transferred to!");
          $("#transfer_bank_paid").focus();
          return;
     }else if(sender.length == 0 || sender.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Name of sender!");
          $("#transfer_sender").focus();
          return;
     }else{
     $.ajax({
          type : "POST",
          url : "../controller/post_other_payments.php",
          data : {posted_by:posted_by, guest:guest, payment_mode:payment_mode, bank_paid:bank_paid, sender:sender, guest_amount:guest_amount, amount_paid:amount_paid},
          success : function(response){
               $("#guest_details").html(response);
          }
     })
          setTimeout(function(){
               $('#guest_details').load("guest_details.php?guest_id=+"+guest + "#guest_details");
          }, 3000);
     }
     return false;    

}

//check out guest
function checkOut(){
     let checkout = confirm("Do you want to check out this guest?", "");
     if(checkout){
          // alert(user_id);
          let user_id = document.getElementById("user_id").value;
          let guest_id = document.getElementById("guest_id").value;
          $.ajax({
               type : "POST",
               url : "../controller/check_out.php",
               data : {user_id:user_id, guest_id:guest_id},
               success : function(response){
                    $("#guest_details").html(response);
               }
          })
          setTimeout(function(){
               $("#guest_details").load("guest_details.php?guest_id="+guest_id+ "#guest_details");
          }, 3000);
     }
     return false;
}
//cancel guest check in
function cancelCheckIn(){
     let cancel = confirm("Do you want to cancel guest check in?", "");
     if(cancel){
          // alert(user_id);
          let user = document.getElementById("user").value;
          let check_id = document.getElementById("check_id").value;
          $.ajax({
               type : "POST",
               url : "../controller/cancel_checkin.php",
               data : {user:user, check_id:check_id},
               success : function(response){
                    $("#guest_details").html(response);
               }
          })
          setTimeout(function(){
               $("#guest_details").load("guest_details.php?guest_id="+check_id+ "#guest_details");
          }, 3000);
     }
     return false;
}

//display any item form
function getForm(item, link){
     // alert(item_id);
     $.ajax({
          type : "GET",
          url : "../controller/"+link+"?item_id="+item,
          success : function(response){
               $(".info").html(response);
               window.scrollTo(0, 0);
          }
     })
     return false;
 
 }


//display stockin form
function displayStockinForm(item_id){
     // alert(item_id);
/*      let invoice = document.getElementById("invoice").value;
     let vendor = document.getElementById("vendor").value; */
     let item = item_id;
          
          $.ajax({
               type : "GET",
               url : "../controller/get_stockin_details.php?item="+item,
               success : function(response){
                    $(".info").html(response);
               }
          })
          $("#sales_item").html("");
          $("#item").val('');
          $("#quantity").focus();

          return false;
     // }
     
 }
//display transfer item form
function addTransfer(item_id){
     let item = item_id;
          
          $.ajax({
               type : "GET",
               url : "../controller/get_transfer_details.php?item="+item,
               success : function(response){
                    $(".info").html(response);
               }
          })
          $("#sales_item").html("");
          $("#item").val("");
          return false;
     // }
     
 }

 //display item purchase history
function checkStockinHistory(item_id){
     // alert(item_id);
/*      let invoice = document.getElementById("invoice").value;
     let vendor = document.getElementById("vendor").value; */
     let item = item_id;
          
          $.ajax({
               type : "GET",
               url : "../controller/stockin_history.php?item="+item,
               success : function(response){
                    $(".new_data").html(response);
               }
          })
          $("#sales_item").html("");
          return false;
     // }
     
 }
 //display item purchase history
function checkwaiterHistory(item_id){
     
     let item = item_id;
          
          $.ajax({
               type : "GET",
               url : "../controller/waiter_history.php?waiter="+item,
               success : function(response){
                    $(".new_data").html(response);
               }
          })
          $("#sales_item").html("");
          $("#item").val("");
          return false;
     // }
     
 }
 //display customer statement/transaction history
function getCustomerStatement(customer_id){
     let customer = customer_id;
          
          $.ajax({
               type : "GET",
               url : "../controller/customer_statement.php?customer="+customer,
               success : function(response){
                    $("#guest_statement").html(response);
               }
          })
          $("#sales_item").html("");
          $("#customer").val("")
          return false;
     // }
     
 }
 //display items in each customer inivoice under statement/transaction history
function viewCustomerInvoice(invoice_id){
     let invoice = invoice_id;
          
          $.ajax({
               type : "GET",
               url : "../controller/customer_invoices.php?invoice="+invoice,
               success : function(response){
                    $("#customer_invoices").html(response);
                    // window.scrollTo(0, 0);
                    document.getElementById("customer_invoices").scrollIntoView();
               }
          })
          $("#sales_item").html("");
          return false;
     // }
     
 }
 //display payment form for credit payments
/* function addPayment(invoice_id){
     let invoice = invoice_id;          
          $.ajax({
               type : "GET",
               url : "../controller/get_payment.php?invoice="+invoice,
               success : function(response){
                    $("#customer_invoices").html(response);
                    // window.scrollTo(0, 0);
                    document.getElementById("customer_invoices").scrollIntoView();
               }
          })
          // $("#sales_item").html("");
          return false;
     // }
     
 } */
 //stockin in items
function stockin(){
     let posted_by = document.getElementById("posted_by").value;
     let store = document.getElementById("store").value;
     let invoice_number = document.getElementById("invoice_number").value;
     let supplier = document.getElementById("supplier").value;
     let item_id = document.getElementById("item_id").value;
     let quantity = document.getElementById("quantity").value;
     let cost_price = document.getElementById("cost_price").value;
     let sales_price = document.getElementById("sales_price").value;
     /* let pack_price = document.getElementById("pack_price").value;
     let pack_size = document.getElementById("pack_size").value; */
     // let wholesale_price = document.getElementById("wholesale_price").value;
    /*  let wholesale_pack = document.getElementById("wholesale_pack").value;
     let expiration_date = document.getElementById("expiration_date").value;
     let todayDate = new Date();
     let today = todayDate.toLocaleDateString(); */
     // alert(today);
     if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity purchased!");
          $("#quantity").focus();
          return;
     }else if(quantity <= 0){
          alert("Please input quantity purchased!");
          $("#quantity").focus();
          return;
     }else if(cost_price.length == 0 || cost_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input cost price");
          $("#cost_price").focus();
          return;
     }else if(sales_price.length == 0 || sales_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input selling price");
          $("#sales_price").focus();
          return;
     }else if(sales_price <= 0){
          alert("Please input selling price");
          $("#sales_price").focus();
          return;
     /* }else if(expiration_date.length == 0 || expiration_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input item expiration date");
          $("#expiration_date").focus();
          return;
     }else if(new Date(today).getTime() > new Date(expiration_date).getTime()){
          alert("You can not stock in expired items!");
          $("#expiration_date").focus();
          return; */
     }else if(parseInt(cost_price) >= parseInt(sales_price)){
          alert("Cost price cannot be greater than selling price!");
          $("#sales_price").focus();
          return;
     /* }else if(parseInt(cost_price) >= parseInt(wholesale_price)){
          alert("Cost price cannot be greater than wholesale price!");
          $("#wholesale_price").focus();
          return; */
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/stock_in.php",
               data : {posted_by:posted_by, store:store, supplier:supplier, invoice_number:invoice_number, item_id:item_id, quantity:quantity, cost_price:cost_price, sales_price:sales_price, /* pack_price:pack_price, pack_size:pack_size, wholesale_price:wholesale_price, /* wholesale_pack:wholesale_pack, expiration_date:expiration_date */},
               success : function(response){
               $(".stocked_in").html(response);
               }
          })
          /* $("#quantity").val('');
          $("#expiration_date").val('');
          $("#quantity").focus(); */
          $("#item").focus();
          $(".info").html('');
          return false; 
     }
}
 //transfer in items
function transfer(){
     let posted_by = document.getElementById("posted_by").value;
     let store_from = document.getElementById("store_from").value;
     let store_to = document.getElementById("store_to").value;
     let invoice = document.getElementById("invoice").value;
     let item_id = document.getElementById("item_id").value;
     let quantity = document.getElementById("quantity").value;
     if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity purchased!");
          $("#quantity").focus();
          return;
     }else if(quantity == "0"){
          alert("Please input quantity purchased!");
          $("#quantity").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/transfer.php",
               data : {posted_by:posted_by, store_to:store_to, store_from:store_from, invoice:invoice, item_id:item_id, quantity:quantity},
               success : function(response){
               $(".stocked_in").html(response);
               }
          })
          /* $("#quantity").val('');
          $("#expiration_date").val('');
          $("#quantity").focus(); */
          $(".info").html('');
          return false; 
     }
}

//delete individual purchases
function deletePurchase(purchase, item){
     let confirmDel = confirm("Are you sure you want to delete this purchase?", "");
     if(confirmDel){
          
          $.ajax({
               type : "GET",
               url : "../controller/delete_purchase.php?purchase_id="+purchase+"&item_id="+item,
               success : function(response){
                    $(".stocked_in").html(response);
               }
               
          })
          return false;
     }else{
          return;
     }
}
//close stock in form
function closeStockin(){
     $("#stockin").load("stockin_purchase.php #stockin");
}


 //adjust item quantity
 function adjustQty(){
     let item_id = document.getElementById("item_id").value;
     let quantity = document.getElementById("quantity").value;
     if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#item_name").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/stock_adjustment.php",
               data: {item_id:item_id, quantity:quantity},
               success : function(response){
                    $("#adjust_quantity").html(response);
               }
          })
          setTimeout(function(){
               $("#adjust_quantity").load("stock_adjustment.php #adjust_quantity");
          }, 1000);
          return false
     }
 }
 
 //remove item quantity from store
 function removeQty(){
     let item_id = document.getElementById("item_id").value;
     let quantity = document.getElementById("quantity").value;
     let remove_reason = document.getElementById("remove_reason").value;
     if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#item_name").focus();
          return;
     }else if(remove_reason.length == 0 || remove_reason.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select reason for removal!");
          $("#remove_reason").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/remove_item.php",
               data: {item_id:item_id, quantity:quantity, remove_reason:remove_reason},
               success : function(response){
                    $("#remove_item").html(response);
               }
          })
          setTimeout(function(){
               $("#remove_item").load("remove_item.php #remove_item");
          }, 2000);
          return false
     }
 }
 //adjust item expiration
 function adjustExpiry(){
     let item_id = document.getElementById("item_id").value;
     let exp_date = document.getElementById("exp_date").value;
     let todayDate = new Date();
     let today = todayDate.toLocaleDateString();
     if(exp_date.length == 0 || exp_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input date!");
          $("#item_name").focus();
          return;
     }else if(new Date(today).getTime() > new Date(exp_date).getTime()){
          alert("Expiration date is invalid!");
          $("#expiration_date").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/adjust_expiration.php",
               data: {item_id:item_id, exp_date:exp_date},
               success : function(response){
                    $("#adjust_expiration").html(response);
               }
          })
          setTimeout(function(){
               $("#adjust_expiration").load("adjust_expiration.php #adjust_expiration");
          }, 2000);
          return false
     }
 }
//  display change rom price
function roomPriceForm(item_id){
     // alert(item_id);
     $.ajax({
          type : "GET",
          url : "../controller/get_room_details.php?item_id="+item_id,
          success : function(response){
               $(".info").html(response);
          }
     })
     return false;
 
 }
 
 //close price form
 function closeForm(){
     
         $(".priceForm").hide();
     
 }
 //change room
 function changeRoom(){
     let posted_by = document.getElementById("posted_by").value;
     let guest = document.getElementById("guest").value;
     let current_room = document.getElementById("current_room").value;
     let new_room = document.getElementById("new_room").value;
     if(new_room.length == 0 || new_room.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room!");
          $("#new_room").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/change_room.php",
               data : {posted_by:posted_by, guest:guest, current_room:current_room, new_room:new_room},
               success : function(response){
                    $("#guest_room_details").html(response);
               }
          })
          setTimeout(function(){
               $("#guest_room_details").load("change_room_form.php?guest_id="+guest+" #guest_room_details");
          }, 2000);
          return false;
     }
}
 //change room price
 function changeRoomPrice(){
     let item_id = document.getElementById("item_id").value;
     let price = document.getElementById("price").value;
     /* let adult = document.getElementById("adult").value;
     let child = document.getElementById("child").value;
     let bathroom = document.getElementById("bathroom").value;
     let washer = document.getElementById("washer").value;
     let aircon = document.getElementById("aircon").value;
     let bed = document.getElementById("bed").value;
     let details = document.getElementById("details").value; */
     if(price.length == 0 || price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter roomprice!");
          $("#price").focus();
          return;
    /*  }else if(washer.length == 0 || washer.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select washing machine!");
          $("#washer").focus();
          return;
     }else if(aircon.length == 0 || aircon.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select air conditioner status!");
          $("#aircon").focus();
          return;
     }else if(details.length == 0 || details.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input room details!");
          $("#details").focus();
          return; */
     }else if(price <= 0 ){
          alert("Values can not be less than 0");
          $("#price").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/edit_room_price.php",
               data: {item_id:item_id, price:price/* , adult:adult, child:child, bathroom:bathroom, washer:washer, bed:bed, aircon:aircon, details:details */},
               success : function(response){
                    $("#edit_price").html(response);
               }
          })
          setTimeout(function(){
               $("#edit_price").load("room_price.php #edit_price");
          }, 1500);
          return false;
     }
 }
 //change other item price
 function changeItemPrice(){
     let item_id = document.getElementById("item_id").value;
     let cost_price = document.getElementById("cost_price").value;
     let sales_price = document.getElementById("sales_price").value;
     // let pack_price = document.getElementById("pack_price").value;
     // let pack_size = document.getElementById("pack_size").value;
     // let wholesale_price = document.getElementById("wholesale_price").value;
     // let wholesale_pack = document.getElementById("wholesale_pack").value;
     if(parseInt(cost_price) >= parseInt(sales_price)){
          alert("Selling price can not be lesser than cost price!");
          $("#sales_price").focus();
          return;
    /*  }else if(parseInt(cost_price) >= parseInt(wholesale_price)){
          alert("Guest price can not be lesser than cost price!");
          $("#wholesale_price").focus();
          return; */
     }else if(cost_price.length == 0 || cost_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter cost price!");
          $("#cost_price").focus();
          return;
     }else if(sales_price.length == 0 || sales_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter selling price!");
          $("#sales_price").focus();
          return;
     /* }else if(wholesale_price.length == 0 || wholesale_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter wholesale price!");
          $("#wholesale_price").focus();
          return; */
     /* }else if(pack_price.length == 0 || pack_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter pack price!");
          $("#pack_price").focus();
          return; */
     /* }else if(pack_price <= cost_price){
          alert("Error! Pack price cannot be lesser than cost price!");
          $("#pack_price").focus();
          return; */
     /* }else if(pack_size.length == 0 || pack_size.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter pack size!");
          $("#pack_size").focus();
          return; */
     }else if(sales_price <=  0){
          alert("Please enter Sales price");
          $("#sales_price").focus();
          return;
     
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/edit_price.php",
               data: {item_id:item_id, cost_price:cost_price, sales_price:sales_price, /* pack_price:pack_price,  wholesale_price:wholesale_price,  wholesale_pack:wholesale_pack, pack_size:pack_size */},
               success : function(response){
                    $("#edit_item_price").html(response);
               }
          })
          setTimeout(function(){
               $("#edit_item_price").load("item_price.php #edit_item_price");
          }, 1500);
          return false
     }
 }
 //modify item name
 function modifyItem(){
     let item_id = document.getElementById("item_id").value;
     let item_name = document.getElementById("item_name").value;
     if(item_name.length == 0 || item_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input item name!");
          $("#item_name").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/modify_item.php",
               data: {item_id:item_id, item_name:item_name},
               success : function(response){
                    $("#edit_item_name").html(response);
               }
          })
          setTimeout(function(){
               $("#edit_item_name").load("modify_item.php #edit_item_name");
          }, 1500);
          return false
     }
 }
 //update item barcode
 function updateBarcode(){
     let item_id = document.getElementById("item_id").value;
     let barcode = document.getElementById("barcode").value;
     if(barcode.length == 0 || barcode.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input item barcode!");
          $("#barcode").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/update_barcode.php",
               data: {item_id:item_id, barcode:barcode},
               success : function(response){
                    $("#update_barcode").html(response);
               }
          })
          setTimeout(function(){
               $("#update_barcode").load("update_barcode.php #update_barcode");
          }, 1500);
          return false
     }
 }
 //change item category
 function changeCategory(){
     let item_id = document.getElementById("item_id").value;
     let department = document.getElementById("department").value;
     let item_category = document.getElementById("item_category").value;
     if(department.length == 0 || department.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select item category!");
          $("#department").focus();
          return;
     }else if(item_category.length == 0 || item_category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select item subcategory!");
          $("#item_category").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/change_category.php",
               data: {item_id:item_id, department:department, item_category:item_category},
               success : function(response){
                    $("#change_category").html(response);
               }
          })
          setTimeout(function(){
               $("#change_category").load("change_category.php #change_category");
          }, 1500);
          return false
     }
 }





// update password
function updatePassword(){
     let username = document.getElementById('username').value;
     let current_password = document.getElementById('current_password').value;
     let new_password = document.getElementById('new_password').value;
     let retype_password = document.getElementById('retype_password').value;
     /* authentication */
     if(current_password == 0 || current_password.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter current password");
          $("#current_password").focus();
          return;
     }else if(new_password == 0 || new_password.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter new password");
          $("#new_password").focus();
          return;
     }else if(new_password.length < 6){
          alert("New password must be greater or equal to 6 characters");
          $("#new_password").focus();
          return;
     }else if(retype_password == 0 || retype_password.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please retype new password");
          $("#retype_password").focus();
          return;
     }else if(new_password !== retype_password){
          alert("Passwords does not match!");
          $("#retype_password").focus();
          return;
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/update_password.php",
               data: {username:username, current_password:current_password, new_password:new_password, retype_password:retype_password},
               success: function(response){
               $(".info").html(response);
               }
          });
     }
     return false;
}
//  Get room reports 
function getRoomReports(room){
     let room_id = room;
     /* authentication */
     if(room_id){
          $.ajax({
               type: "POST",
               url: "../controller/room_reports.php",
               data: {room_id:room_id},
               success: function(response){
                    $(".new_data").html(response);
               }
          });
     }else{
          alert("select a room!");
          return;
     }
     return false;
}
//  Get rooms 
function getRooms(category){
     let check_in_category = category;
     /* authentication */
     if(check_in_category){
          $.ajax({
               type: "POST",
               url: "../controller/get_rooms.php",
               data: {check_in_category:check_in_category},
               success: function(response){
                    $("#check_in_room").html(response);
               }
          });
     }else{
          alert("select a room!");
          return;
     }
     return false;
}

//get vendors
function getVendors(vendor){
     let ven_input = vendor;
     if(ven_input){
          $.ajax({
               type : "POST",
               url :"../controller/get_vendors.php",
               data : {ven_input:ven_input},
               success : function(response){
                    $("#vendors").html(response);
               }
          })
          return false;
     }else{
          $("#vendors").html("<option value='' selected>No result</option>")
     }
     
}

//show bill types forms
/* function showRetail(){
     $("#retail_customers").show();
     $("#wholesale_customers").hide();
}
function showWholesale(){
     $("#retail_customers").hide();
     $("#wholesale_customers").show();
} */
//show sales form categories (bar and restuarant)
function showBar(){
     $("#bar_items").show();
     $("#restaurant_items").hide();
}
function showRestaurant(){
     $("#bar_items").hide();
     $("#restaurant_items").show();
}

//get item for direct sales
function getItems(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     if(item.length >= 3){
          if(item){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_items.php",
                    data : {item:item},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     }
     
}
//get item for sales order
function getItemsOrder(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     if(item.length >= 3){
          if(item){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_sales_order_items.php",
                    data : {item:item},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     }
     
}
//get item for wholesale direct sales
function getWholesaleItems(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     if(item.length >= 3){
          if(item){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_wholesale_items.php",
                    data : {item:item},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     }
     
}
//get item for stockin
function getItemStockin(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     let invoice = document.getElementById("invoice").value;
     let vendor = document.getElementById("vendor").value;
     if(invoice.length == 0 || invoice.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input invoice number!");
          $("#invoice").focus();
          return;
     }else if(vendor.length == 0 || vendor.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select supplier!");
          $("#vendor").focus();
          return;
     }else{
          if(item.length >= 3){
               if(item){
                    $.ajax({
                         type : "POST",
                         url :"../controller/get_item_stockin.php",
                         data : {item:item, invoice:invoice, vendor:vendor},
                         success : function(response){
                              $("#sales_item").html(response);
                         }
                    })
                    $("#invoice").attr("readonly", true);
                    $("#vendor").attr("readonly", true);
                    return false;
               }else{
                    $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
               }
          }
     }
     
}
//get item for transfer
function getItemTransfer(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     let invoice = document.getElementById("invoice").value;
     let store_to = document.getElementById("store_to").value;
     if(store_to.length == 0 || store_to.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a store!");
          $("#store_to").focus();
          return;
     }else{
          if(item.length >= 3){
               if(item){
                    $.ajax({
                         type : "POST",
                         url :"../controller/get_item_transfer.php",
                         data : {item:item,  store_to:store_to, invoice:invoice},
                         success : function(response){
                              $("#sales_item").html(response);
                         }
                    })
                    $("#store_to").attr("readonly", true);
                    return false;
               }else{
                    $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
               }
          }
     }
     
}
//get customer statement
function getCustomer(customer_id){
     let customer = customer_id;
     // alert(check_room);
     // return;
     /* let fromDate = document.getElementById("fromDate").value;
     let toDate = document.getElementById("toDate").value;
     if(fromDate.length == 0 || fromDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#fromDate").focus();
          return;
     }else if(toDate.length == 0 || toDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#toDate").focus();
          return;
     }else{ */
     if(customer.length >= 3){
          if(customer){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_customer.php",
                    data : {customer:customer/* , fromDate:fromDate, toDate:toDate */},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               /* $("#fromDate").attr("readonly", true);
               $("#toDate").attr("readonly", true); */
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     // }

}
     
}
//get item for stockin history
function getStockinItem(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     let fromDate = document.getElementById("fromDate").value;
     let toDate = document.getElementById("toDate").value;
     if(fromDate.length == 0 || fromDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#fromDate").focus();
          return;
     }else if(toDate.length == 0 || toDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#toDate").focus();
          return;
     }else{
     if(item.length >= 3){
          if(item){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_item_purchase.php",
                    data : {item:item, fromDate:fromDate, toDate:toDate},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               /* $("#fromDate").attr("readonly", true);
               $("#toDate").attr("readonly", true); */
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     }
}
     
}
//get item for stockin history
function getWaiterOrder(item_name){
     let item = item_name;
     // alert(check_room);
     // return;
     let fromDate = document.getElementById("fromDate").value;
     let toDate = document.getElementById("toDate").value;
     if(fromDate.length == 0 || fromDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#fromDate").focus();
          return;
     }else if(toDate.length == 0 || toDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#toDate").focus();
          return;
     }else{
     if(item.length >= 3){
          if(item){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_waiter_order.php",
                    data : {item:item, fromDate:fromDate, toDate:toDate},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               /* $("#fromDate").attr("readonly", true);
               $("#toDate").attr("readonly", true); */
               // $("#item").val('');
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     }
}
     
}
//search vendor history
function vendorHistory(){
     let vendor = document.getElementById("vendor").value;
     // alert(check_room);
     // return;
     let fromDate = document.getElementById("fromDate").value;
     let toDate = document.getElementById("toDate").value;
     if(fromDate.length == 0 || fromDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#fromDate").focus();
          return;
     }else if(toDate.length == 0 || toDate.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#toDate").focus();
          return;
     }else if(vendor.length == 0 || vendor.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a vendor!");
          $("#toDate").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url :"../controller/vendor_history.php",
               data : {vendor:vendor, fromDate:fromDate, toDate:toDate},
               success : function(response){
                    $(".new_data").html(response);
               }
          })
         
     }
}
     


//add direct sales 
function addSales(item_id){
     let item = item_id;
     let invoice = document.getElementById("invoice").value;
     $.ajax({
          type : "GET",
          url : "../controller/add_sales.php?sales_item="+item+"&invoice="+invoice,
          success : function(response){
               $(".sales_order").html(response);
          }
     })
     $("#sales_item").html("");
     $("#item").val('');

     return false;
}

//add sales order
function addSalesOrder(item_id){
     let item = item_id;
     let invoice = document.getElementById("invoice").value;
     let add_order = document.getElementById("add_order").value;
     let order_by = document.getElementById("order_by").value;
     $.ajax({
          type : "GET",
          url : "../controller/add_sales_order.php?sales_item="+item+"&invoice="+invoice+"&order="+add_order+"&waiter="+order_by,
          success : function(response){
               $(".sales_order").html(response);
          }
     })
     $("#sales_item").html("");
     $("#item").val('');
     $("#item").focus();

     return false;
}
//add direct wholesales 
function addWholeSales(item_id){
     let item = item_id;
     let customer = document.getElementById("customer").value;
     let invoice = document.getElementById("invoice").value;
     $.ajax({
          type : "GET",
          url : "../controller/add_wholesale.php?sales_item="+item+"&customer="+customer+"&invoice="+invoice,
          success : function(response){
               $(".sales_order").html(response);
          }
     })
     $("#sales_item").html("");
     $("#item").val('');

     return false;
}
//delete individual items from direct sales
function deleteSales(sales, item){
     let confirmDel = confirm("Are you sure you want to remove this item?", "");
     if(confirmDel){
          
          $.ajax({
               type : "GET",
               url : "../controller/delete_sales.php?sales_id="+sales+"&item_id="+item,
               success : function(response){
                    $(".sales_order").html(response);
               }
               
          })
          return false;
     }else{
          return;
     }
}
//delete item
function deleteItem(item){
     let confirmDel = confirm("Are you sure you want to delete this item?", "");
     if(confirmDel){
          $.ajax({
               type : "GET",
               url : "../controller/delete_item.php?item="+item,
               success : function(response){
                    $("#delete_item").html(response);
               }
          })
          setTimeout(function(){
               $("#delete_item").load("delete_item.php #delete_item");
          }, 1500);
          return false;
          
     }else{
          return;
     }
}
//delete individual items from sales order
function deleteSalesOrder(sales, item){
     let confirmDel = confirm("Are you sure you want to remove this item?", "");
     if(confirmDel){
          
          $.ajax({
               type : "GET",
               url : "../controller/delete_sales_order.php?sales_id="+sales+"&item_id="+item,
               success : function(response){
                    $(".sales_order").html(response);
               }
               
          })
          return false;
     }else{
          return;
     }
}
//delete items from sales view sales order
function getReturnItem(sales){
     /* let confirmDel = confirm("Are you sure you want to remove this item?", "");
     if(confirmDel){ */
          
          $.ajax({
               type : "GET",
               url : "../controller/get_item_order.php?sales_id="+sales,
               success : function(response){
                    $(".info").html(response);
                    window.scrollTo(0, 0);
               }
               
          })
          return false;
     /* }else{
          return;
     } */
}
//delete items from sales ordered for guest in hotel
function getGuestReturnItem(sales, id){
     /* let confirmDel = confirm("Are you sure you want to remove this item?", "");
     if(confirmDel){ */
          
          $.ajax({
               type : "GET",
               url : "../controller/get_guest_item_order.php?sales_id="+sales+"&guest_id="+id,
               success : function(response){
                    $(".info").html(response);
                    window.scrollTo(0, 0);
               }
               
          })
          return false;
     /* }else{
          return;
     } */
}
//return item from sales order
function returnItem(){
     let return_sales = confirm("Are you sure you want to return this sales?", "");
     if(return_sales){
          let item = document.getElementById("item").value;
          let sold_qty = document.getElementById("sold_qty").value;
          let sales_id = document.getElementById("sales_id").value;
          let user_id = document.getElementById("user_id").value;
          let store = document.getElementById("store").value;
          let invoice = document.getElementById("invoice").value;
          let quantity = document.getElementById("quantity").value;
          let reason = document.getElementById("reason").value;
          if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please input quantity!");
               $("#quantity").focus();
               return;
          }else if(quantity > sold_qty){
               alert("You cannot return more than what was sold!");
               $("#quantity").focus();
               return;
          }else if(reason.length == 0 || reason.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please input reason for return!");
               $("#reason").focus();
               return;
          }else{
               $.ajax({
                    type : "POST",
                    url : "../controller/return_item_ordered.php",
                    data: {item:item, sales_id:sales_id, user_id:user_id, quantity:quantity, reason:reason, store:store},
                    success : function(response){
                         $("#sales_details").html(response);
                    }
               })
               setTimeout(function(){
                    $("#sales_details").load("sales_details.php?invoice="+invoice+" #sales_details");
               }, 1500);
               return false
          }
     }else{
          return;
     }
}
//return item from sales order
function returnGuestItem(id){
     let return_sales = confirm("Are you sure you want to return this sales?", "");
     if(return_sales){
          let item = document.getElementById("item").value;
          let sold_qty = document.getElementById("sold_qty").value;
          let sales_id = document.getElementById("sales_id").value;
          let user_id = document.getElementById("user_id").value;
          let store = document.getElementById("store").value;
          let invoice = document.getElementById("invoice").value;
          let quantity = document.getElementById("quantity").value;
          let reason = document.getElementById("reason").value;
          if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please input quantity!");
               $("#quantity").focus();
               return;
          }else if(quantity > sold_qty){
               alert("You cannot return more than what was sold!");
               $("#quantity").focus();
               return;
          }else if(reason.length == 0 || reason.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please input reason for return!");
               $("#reason").focus();
               return;
          }else{
               $.ajax({
                    type : "POST",
                    url : "../controller/return_item_ordered.php",
                    data: {item:item, sales_id:sales_id, user_id:user_id, quantity:quantity, reason:reason, store:store},
                    success : function(response){
                         $("#guest_details").html(response);
                    }
               })
               setTimeout(function(){
                    $("#guest_details").load("guest_details.php?guest_id="+id+" #guest_details");
               }, 1000);
               return false
          }
     }else{
          return;
     }
}
//delete individual items from direct wholesale
function deleteWholesale(sales, item){
     let confirmDel = confirm("Are you sure you want to remove this item?", "");
     if(confirmDel){
          
          $.ajax({
               type : "GET",
               url : "../controller/delete_wholesale.php?sales_id="+sales+"&item_id="+item,
               success : function(response){
                    $(".sales_order").html(response);
               }
               
          })
          return false;
     }else{
          return;
     }
}
//increase quantity for direct sales item
function increaseQty(sales, item){
     // alert(sales);
     $.ajax({
          type : "GET",
          url : "../controller/increase_qty.php?sales_id="+sales+"&item_id="+item,
          success : function(response){
               $(".sales_order").html(response);
          }
          
     })
     return false;
}
//increase quantity for sales order item
function increaseQtyOrder(sales, item){
     // alert(sales);
     $.ajax({
          type : "GET",
          url : "../controller/increase_qty_order.php?sales_id="+sales+"&item_id="+item,
          success : function(response){
               $(".sales_order").html(response);
          }
          
     })
     return false;
}
//increase quantity for direct wholesalesales item
function increaseQtyWholesale(sales, item){
     // alert(sales);
     $.ajax({
          type : "GET",
          url : "../controller/increase_qty_wholesale.php?sales_id="+sales+"&item_id="+item,
          success : function(response){
               $(".sales_order").html(response);
          }
          
     })
     return false;
}
//decrease quantity for direct sales item
function reduceQty(sales){
     $.ajax({
          type : "GET",
          url : "../controller/decrease_qty.php?item="+sales,
          success : function(response){
               $(".sales_order").html(response);
          }
          
     })
     return false;
}
//decrease quantity for sales order item
function reduceQtyOrder(sales){
     $.ajax({
          type : "GET",
          url : "../controller/decrease_qty_order.php?item="+sales,
          success : function(response){
               $(".sales_order").html(response);
          }
          
     })
     return false;
}
//decrease quantity for direct wholesalesales item
function reduceQtyWholesale(sales){
     $.ajax({
          type : "GET",
          url : "../controller/decrease_qty_wholesale.php?item="+sales,
          success : function(response){
               $(".sales_order").html(response);
          }
          
     })
     return false;
}
//show more options for sales item to edit price and quantity
function showMore(sales){
     $.ajax({
          type : "GET",
          url : "../controller/edit_price_qty.php?item="+sales,
          success : function(response){
               $(".show_more").html(response);
               window.scrollTo(0, 0);
          }
          
     })
     return false;
}
//show more options for sales order item to edit price and quantity
function showMoreOrder(sales){
     $.ajax({
          type : "GET",
          url : "../controller/edit_price_qty_order.php?item="+sales,
          success : function(response){
               $(".show_more").html(response);
               window.scrollTo(0, 0);

          }
          
     })
     return false;
}
//show more options for sales item to edit price and quantity
function showMoreWholesale(sales){
     $.ajax({
          type : "GET",
          url : "../controller/edit_price_qty_wholesale.php?item="+sales,
          success : function(response){
               $(".show_more").html(response);
               window.scrollTo(0, 0);

          }
          
     })
     return false;
}
//update sales quantity and price for direct sales
function updatePriceQty(){
     let sales_id = document.getElementById("sales_id").value;
     let qty = document.getElementById("qty").value;
     let price = document.getElementById("price").value;
     // let inv_qty = document.getElementById("inv_qty").value;
     /* authentication */
     if(qty.length == 0 || qty.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#qty").focus();
          return;
     }else if(price.length == 0 || price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input unit price!");
          $("#price").focus();
          return;
     }else if(qty < 1){
          alert("Qauntity cannot be zero or negative!");
          $("#qty").focus();
          return;
     }else if(price < 1){
          alert("Price cannot be zero or negative!");
          $("#price").focus();
          return;
     /* }else if(qty > inv_qty){
          alert("Available quantity is less than required!");
          $("#qty").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/update_price_qty.php",
               data: {sales_id:sales_id, qty:qty, price:price},
               success: function(response){
               $(".sales_order").html(response);
               }
          });

     }
     $(".show_more").html('');
     return false;
}
//update sales quantity and price for sales order
function updatePriceQtyOrder(){
     let sales_id = document.getElementById("sales_id").value;
     let qty = document.getElementById("qty").value;
     let price = document.getElementById("price").value;
     // let inv_qty = document.getElementById("inv_qty").value;
     /* authentication */
     if(qty.length == 0 || qty.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#qty").focus();
          return;
     }else if(price.length == 0 || price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input unit price!");
          $("#price").focus();
          return;
     }else if(qty < 1){
          alert("Qauntity cannot be zero or negative!");
          $("#qty").focus();
          return;
     }else if(price < 1){
          alert("Price cannot be zero or negative!");
          $("#price").focus();
          return;
     /* }else if(qty > inv_qty){
          alert("Available quantity is less than required!");
          $("#qty").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/update_price_qty_order.php",
               data: {sales_id:sales_id, qty:qty, price:price},
               success: function(response){
               $(".sales_order").html(response);
               }
          });

     }
     $(".show_more").html('');
     return false;
}
//update sales quantity and price for wholesale
function updatePriceQtyWh(){
     let sales_id = document.getElementById("sales_id").value;
     let qty = document.getElementById("qty").value;
     let price = document.getElementById("price").value;
     // let inv_qty = document.getElementById("inv_qty").value;
     /* authentication */
     if(qty.length == 0 || qty.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#qty").focus();
          return;
     }else if(price.length == 0 || price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input unit price!");
          $("#price").focus();
          return;
     }else if(qty < 1){
          alert("Qauntity cannot be zero or negative!");
          $("#qty").focus();
          return;
     }else if(price < 1){
          alert("Price cannot be zero or negative!");
          $("#price").focus();
          return;
     /* }else if(qty > inv_qty){
          alert("Available quantity is less than required!");
          $("#qty").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/update_price_qty_who.php",
               data: {sales_id:sales_id, qty:qty, price:price},
               success: function(response){
               $(".sales_order").html(response);
               }
          });

     }
     $(".show_more").html('');
     return false;
}
//get item pack price and size for direct sales
function getPack(sales){
     $.ajax({
          type : "GET",
          url : "../controller/get_pack.php?sales_id="+sales,
          success : function(response){
               $(".show_more").html(response);
          }
          
     })
     return false;
}
//get item pack price and size for sales order
function getPackSo(sales){
     $.ajax({
          type : "GET",
          url : "../controller/get_pack_so.php?sales_id="+sales,
          success : function(response){
               $(".show_more").html(response);
          }
          
     })
     return false;
}
//get item pack price and size for wholesale
function getWholesalePack(sales){
     $.ajax({
          type : "GET",
          url : "../controller/get_pack_wholesale.php?sales_id="+sales,
          success : function(response){
               $(".show_more").html(response);
          }
          
     })
     return false;
}
//sell item in pack for direct sales
function sellPack(){
     let sales_id = document.getElementById("sales_id").value;
     let pack_qty = document.getElementById("pack_qty").value;
     let pack_price = document.getElementById("pack_price").value;
     let pack_size = document.getElementById("pack_size").value;
     // let inv_qty = document.getElementById("inv_qty").value;
     /* authentication */
     if(pack_qty.length == 0 || pack_qty.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#pack_qty").focus();
          return;
     }else if(pack_price.length == 0 || pack_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input unit price!");
          $("#pack_price").focus();
          return;
     }else if(pack_qty <= 0 ){
          alert("Qauntity cannot be zero or negative!");
          $("#pack_qty").focus();
          return;
     }else if(pack_price <= 0){
          alert("Price cannot be zero or negative!");
          $("#pack_price").focus();
          return;
     /* }else if(qty > inv_qty){
          alert("Available quantity is less than required!");
          $("#qty").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/sell_pack.php",
               data: {sales_id:sales_id, pack_qty:pack_qty, pack_price:pack_price, pack_size:pack_size},
               success: function(response){
               $(".sales_order").html(response);
               }
          });

     }
     $(".show_more").html('');
     return false;
}
//sell item in pack for sales order
function sellPackSo(){
     let sales_id = document.getElementById("sales_id").value;
     let pack_qty = document.getElementById("pack_qty").value;
     let pack_price = document.getElementById("pack_price").value;
     let pack_size = document.getElementById("pack_size").value;
     // let inv_qty = document.getElementById("inv_qty").value;
     /* authentication */
     if(pack_qty.length == 0 || pack_qty.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#pack_qty").focus();
          return;
     }else if(pack_price.length == 0 || pack_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input unit price!");
          $("#pack_price").focus();
          return;
     }else if(pack_qty <= 0){
          alert("Qauntity cannot be zero or negative!");
          $("#pack_qty").focus();
          return;
     }else if(pack_price <= 0){
          alert("Price cannot be zero or negative!");
          $("#pack_price").focus();
          return;
     /* }else if(qty > inv_qty){
          alert("Available quantity is less than required!");
          $("#qty").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/sell_pack_so.php",
               data: {sales_id:sales_id, pack_qty:pack_qty, pack_price:pack_price, pack_size:pack_size},
               success: function(response){
               $(".sales_order").html(response);
               }
          });

     }
     $(".show_more").html('');
     return false;
}
//sell item in pack for wholesale
function sellPackWholesale(){
     let sales_id = document.getElementById("sales_id").value;
     let pack_qty = document.getElementById("pack_qty").value;
     let pack_price = document.getElementById("pack_price").value;
     let pack_size = document.getElementById("pack_size").value;
     // let inv_qty = document.getElementById("inv_qty").value;
     /* authentication */
     if(pack_qty.length == 0 || pack_qty.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input quantity!");
          $("#pack_qty").focus();
          return;
     }else if(pack_price.length == 0 || pack_price.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input unit price!");
          $("#pack_price").focus();
          return;
     }else if(pack_qty <= 0 ){
          alert("Qauntity cannot be zero or negative!");
          $("#pack_qty").focus();
          return;
     }else if(pack_price <= 0){
          alert("Price cannot be zero or negative!");
          $("#pack_price").focus();
          return;
     /* }else if(qty > inv_qty){
          alert("Available quantity is less than required!");
          $("#qty").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/sell_pack_wholesale.php",
               data: {sales_id:sales_id, pack_qty:pack_qty, pack_price:pack_price, pack_size:pack_size},
               success: function(response){
               $(".sales_order").html(response);
               }
          });

     }
     $(".show_more").html('');
     return false;
}
//check all payment mode
function checkMode(mode){
     let pay_mode = mode;
     let bank_input = document.getElementById("selectBank");
     let multiples = document.getElementById("multiples");
     let wallet = document.getElementById("account_balance");
     let label = document.getElementById("amount_label");
     let deposits = document.getElementById("deposits");
     if(pay_mode == "POS" || pay_mode == "Transfer"){
          bank_input.style.display = "block";
          multiples.style.display = "none";
          wallet.style.display = "none";
          label.style.display = "block";
          deposits.type = "text";
     }else if(pay_mode == "Multiple"){
          multiples.style.display = "block";
          bank_input.style.display = "block";
          label.style.display = "none";
          deposits.type = "hidden";
          wallet.style.display = "none";
     }else if(pay_mode == "Wallet"){
          wallet.style.display = "block";
          multiples.style.display = "none";
          bank_input.style.display = "none";
          label.style.display = "none";
          deposits.type = "hidden";
     }else{
          bank_input.style.display = "none";
          multiples.style.display = "none";
          wallet.style.display = "none";
          label.style.display = "block";
          deposits.type = "text";
     }
}
//check add payment mode
function checkOtherMode(mode){
     let pay_mode = mode;
     let bank_input = document.getElementById("selectBank");
     // let multiples = document.getElementById("multiples");
     let wallet = document.getElementById("account_balance");
     let label = document.getElementById("amount_label");
     let deposits = document.getElementById("deposits");
     if(pay_mode == "POS" || pay_mode == "Transfer"){
          bank_input.style.display = "block";
          // multiples.style.display = "none";
          wallet.style.display = "none";
          label.style.display = "block";
          deposits.type = "text";
     
     }else if(pay_mode == "Wallet"){
          wallet.style.display = "block";
          // multiples.style.display = "none";
          bank_input.style.display = "none";
          label.style.display = "block";
          deposits.type = "text";
     }else{
          bank_input.style.display = "none";
          // multiples.style.display = "none";
          wallet.style.display = "none";
          label.style.display = "block";
          deposits.type = "text";
     }
}
//post direct sales payment
function postSales(){
     let confirmPost = confirm("Are you sure you want to post this sales?", "");
     if(confirmPost){
          let total_amount = document.getElementById("total_amount").value;
          let sales_invoice = document.getElementById("sales_invoice").value;
          let discount = document.getElementById("discount").value;
          let store = document.getElementById("store").value;
          let payment_type = document.getElementById("payment_type").value;
          let bank = document.getElementById("bank").value;
          let multi_cash = document.getElementById("multi_cash").value;
          let multi_pos = document.getElementById("multi_pos").value;
          let multi_transfer = document.getElementById("multi_transfer").value;
          let sum_amount = parseInt(multi_cash) + parseInt(multi_pos) + parseInt(multi_transfer);
          if(document.getElementById("multiples").style.display == "block"){
               if(sum_amount != (total_amount - discount)){
                    alert("Amount entered is not equal to total amount");
                    $("#multi_cash").focus();
                    return;
               }
          }
          if(payment_type.length == 0 || payment_type.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please select a payment option!");
               $("#payment_type").focus();
               return;
          }else if(discount.length == 0 || discount.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please enter discount value or 0!");
               $("#discount").focus();
               return;
          }else{
               $.ajax({
                    type : "POST",
                    url : "../controller/post_sales.php",
                    data : {sales_invoice:sales_invoice, payment_type:payment_type, bank:bank, multi_cash:multi_cash, multi_pos:multi_pos, multi_transfer:multi_transfer, discount:discount, store:store},
                    success : function(response){
                         $("#direct_sales").html(response);
                    }
               })
               $(".sales_order").html('');
               /* setTimeout(function(){
                    $("#direct_sales").load("direct_sales.php #direct_sales");
               }, 200);
               return false; */
          }
     // }
     }else{
          return;
     }
}
//post sales order payment
function postSalesOrder(){
     let confirmPost = confirm("Are you sure you want to post this sales?", "");
     if(confirmPost){
          let total_amount = document.getElementById("total_amount").value;
          let discount = document.getElementById("discount").value;
          // alert(total_amount);
          let sales_invoice = document.getElementById("sales_invoice").value;
          let payment_type = document.getElementById("payment_type").value;
          let bank = document.getElementById("bank").value;
          let store = document.getElementById("store").value;
          let multi_cash = document.getElementById("multi_cash").value;
          let multi_pos = document.getElementById("multi_pos").value;
          let multi_transfer = document.getElementById("multi_transfer").value;
          let sum_amount = parseInt(multi_cash) + parseInt(multi_pos) + parseInt(multi_transfer);
          if(document.getElementById("multiples").style.display == "block"){
               //check if total amount is greater than sum
               if(sum_amount != (total_amount - discount)){
                    alert("Amount entered is not equal to total amount");
                    $("#multi_cash").focus();
                    return;
               }
               if(bank.length == 0 || bank.replace(/^\s+|\s+$/g, "").length == 0){
                    alert("Please select bank!");
                    $("#bank").focus();
                    return;
               }
          }
          if(payment_type == "Transfer" || payment_type == "POS" || payment_type == "Multiple"){
               if(bank.length == 0 || bank.replace(/^\s+|\s+$/g, "").length == 0){
                    alert("Please select bank!");
                    $("#bank").focus();
                    return;
               }
          }
          if(payment_type.length == 0 || payment_type.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please select a payment option!");
               $("#payment_type").focus();
               return;
          }else if(discount.length == 0 || discount.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please enter discount value or 0!");
               $("#discount").focus();
               return;
          }else{
               $.ajax({
                    type : "POST",
                    url : "../controller/post_sales_order.php",
                    data : {sales_invoice:sales_invoice, payment_type:payment_type, bank:bank, multi_cash:multi_cash, multi_pos:multi_pos, multi_transfer:multi_transfer, discount:discount, store:store},
                    success : function(response){
                         $("#sales_details").html(response);
                    }
               })
               // $(".sales_order").html('');
               /* setTimeout(function(){
                    $("#direct_sales").load("direct_sales.php #direct_sales");
               }, 200);
               return false; */
          }
     }else{
          return;
     }
}
//post sales order ticket
function printSalesOrder(link){
     let confirmPost = confirm("Are you sure you want to post this sales?", "");
     if(confirmPost){
          let sales_invoice = document.getElementById("sales_invoice").value;
          
          
          $.ajax({
               type : "POST",
               url : "../controller/"+link,
               data : {sales_invoice:sales_invoice},
               success : function(response){
                    $("#sales_order").html(response);
               }
          })
          $(".sales_order").html('');
          /* setTimeout(function(){
               $("#direct_sales").load("direct_sales.php #direct_sales");
          }, 200);
          return false; */
     }
}
//post guest payments
function postPayment(){
     let total_amount = document.getElementById("total_amount").value;
     let deposits = document.getElementById("deposits").value;
     let sales_invoice = document.getElementById("sales_invoice").value;
     let discount = document.getElementById("discount").value;
     let store = document.getElementById("store").value;
     let check_in_id = document.getElementById("check_in_id").value;
     let payment_type = document.getElementById("payment_type").value;
     let bank = document.getElementById("bank").value;
     let multi_cash = document.getElementById("multi_cash").value;
     let multi_pos = document.getElementById("multi_pos").value;
     let multi_transfer = document.getElementById("multi_transfer").value;
     let wallet = document.getElementById("wallet").value;
     let sum_amount = parseInt(multi_cash) + parseInt(multi_pos) + parseInt(multi_transfer);
     if(payment_type == "Transfer" || payment_type == "POS"){
          if(bank.length == 0 || bank.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please select bank!");
               $("#bank").focus();
               return;
          }
     }
     if(payment_type == "Wallet"){
          if(parseInt(wallet) <= 0){
               alert("Insufficient balance! Kindly fund wallet");
               $("#payment_type").focus();
               return;
          }
     
     }else if(document.getElementById("multiples").style.display == "block"){
          if(sum_amount < (parseInt(total_amount) - parseInt(discount))){
               alert("Please enter a valid amount");
               $("#multi_cash").focus();
               return;
          }
     }else{
          if(parseInt(deposits) <= 0){
               alert("Please input amount deposited!");
               $("#deposits").focus();
          return;
          }
     }
     if(payment_type.length == 0 || payment_type.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a payment option!");
          $("#payment_type").focus();
          return;
     }else if(deposits.length == 0 || deposits.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount deposited!");
          $("#deposits").focus();
          return;
     
     }else if(discount.length == 0 || discount.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter discount value or 0!");
          $("#discount").focus();
          return;
          
     }else{
          let confirmPost = confirm("Are you sure you want to post this transaction?", "");
          if(confirmPost){
               $.ajax({
                    type : "POST",
                    url : "../controller/post_payments.php",
                    data : {sales_invoice:sales_invoice, payment_type:payment_type, bank:bank, multi_cash:multi_cash, multi_pos:multi_pos, multi_transfer:multi_transfer, discount:discount, store:store, total_amount:total_amount, deposits:deposits, wallet:wallet, check_in_id:check_in_id},
                    success : function(response){
                         $("#all_payments").html(response);
                    }
               })
          }else{
               return;
          }
          /* setTimeout(function(){
               $("#guest_payment").load("guest_payment.php #guest_payment");
          }, 2000); */
          return false;
     }
     
}
//add guest payment
function addPayment(){
     let total_amount = document.getElementById("total_amount").value;
     let deposits = document.getElementById("deposits").value;
     let check_in_id = document.getElementById("check_in_id").value;
     let payment_type = document.getElementById("payment_type").value;
     let bank = document.getElementById("bank").value;
     let wallet = document.getElementById("wallet").value;
     // alert(bank);
     if(payment_type == "Transfer" || payment_type == "POS"){
          if(bank.length == 0 || bank.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please select bank!");
               $("#bank").focus();
               return;
          }
     }
     if(payment_type == "Wallet"){
          if(parseInt(wallet) < parseInt(deposits)){
               alert("Insufficient balance! Kindly fund wallet");
               $("#payment_type").focus();
               return;
          }
     
     }
     if(payment_type.length == 0 || payment_type.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a payment option!");
          $("#payment_type").focus();
          return;
     }else if(deposits.length == 0 || deposits.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount deposited!");
          $("#deposits").focus();
          return;
          
     }else{
          let confirmPost = confirm("Are you sure you want to post this transaction?", "");
          if(confirmPost){
               $.ajax({
                    type : "POST",
                    url : "../controller/add_payments.php",
                    data : {payment_type:payment_type, bank:bank, total_amount:total_amount, deposits:deposits, check_in_id:check_in_id},
                    success : function(response){
                         $("#guest_details").html(response);
                    }
               })
          }else{
               return;
          }
          setTimeout(function(){
               $("#guest_details").load("guest_details.php?guest_id="+check_in_id+ "#guest_details");;
          }, 2000);
          return false;
     }
     
}

// prinit transfer receipt
function printTransferReceipt(invoice){
     window.open("../controller/transfer_receipt.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_receipt.php?receipt="+invoice,
          success : function(response){
               $("#direct_sales").html(response);
          }
     }) */
     setTimeout(function(){
          $("#direct_sales").load("direct_sales.php #direct_sales");
     }, 100);
     return false;
 
 }
//post direct wholesale payment
function postGuestOrder(){
     
          // let total_amount = document.getElementById("total_amount").value;
          let sales_invoice = document.getElementById("sales_invoice").value;
          // let discount = document.getElementById("discount").value;
          let store = document.getElementById("store").value;
          let customer_id = document.getElementById("customer_id").value;
          let payment_type = document.getElementById("payment_type").value;
          /* let bank = document.getElementById("bank").value;
          let multi_cash = document.getElementById("multi_cash").value;
          let multi_pos = document.getElementById("multi_pos").value;
          let multi_transfer = document.getElementById("multi_transfer").value;
          let wallet = document.getElementById("wallet").value;
          let sum_amount = parseInt(multi_cash) + parseInt(multi_pos) + parseInt(multi_transfer); */
          /* if(document.getElementById("multiples").style.display == "block"){
               if(sum_amount != (total_amount - discount)){
                    alert("Amount entered is not equal to total amount");
                    $("#multi_cash").focus();
                    return;
               }
          }
          if(document.getElementById("account_balance").style.display == "block"){
               if(parseInt(total_amount - discount) > parseInt(wallet)){
                    alert("Insufficient balance! Kindly fund wallet");
                    $("#payment_type").focus();
                    return;
               }
          }
          if(payment_type.length == 0 || payment_type.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please select a payment option!");
               $("#payment_type").focus();
               return;
          }else if(discount.length == 0 || discount.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please enter discount value or 0!");
               $("#discount").focus();
               return; */
               let confirmPost = confirm("Are you sure you want to post this sales?", "");
               if(confirmPost){
               $.ajax({
                    type : "POST",
                    url : "../controller/post_wholesale.php",
                    data : {sales_invoice:sales_invoice, payment_type:payment_type, /* bank:bank, multi_cash:multi_cash, multi_pos:multi_pos, multi_transfer:multi_transfer, discount:discount, wallet:wallet, */ store:store, customer_id:customer_id},
                    success : function(response){
                         $("#direct_sales").html(response);
                    }
               })
               $(".sales_order").html('');
               /* setTimeout(function(){
                    $("#direct_sales").load("direct_sales.php #direct_sales");
               }, 200);
               return false; */
          }else{
                    return;
               }
     // }
}
 //adjust item quantity
 function adjustReorderLevel(){
     let item_id = document.getElementById("item_id").value;
     let rol = document.getElementById("rol").value;
     if(rol.length == 0 || rol.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input reorder level!");
          $("#rol").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/reorder_level.php",
               data: {item_id:item_id, rol:rol},
               success : function(response){
                    $("#reorder_levels").html(response);
               }
          })
          setTimeout(function(){
               $("#reorder_levels").load("reorder_level.php #reorder_levels");
          }, 2000);
          return false
     }
 }

 //display sales return form
function displaySales(sales_id){
     // alert(item_id);
     $.ajax({
          type : "GET",
          url : "../controller/get_sales.php?sales_id="+sales_id,
          success : function(response){
               $(".select_date").html(response);
               window.scrollTo(0, 0);

          }
     })
     return false;
 
 }
 //sales return
 function returnSales(){
     let return_sales = confirm("Are you sure you want to return this sales?", "");
     if(return_sales){
          let item = document.getElementById("item").value;
          let sold_qty = document.getElementById("sold_qty").value;
          let sales_id = document.getElementById("sales_id").value;
          let user_id = document.getElementById("user_id").value;
          let store = document.getElementById("store").value;
          let quantity = document.getElementById("quantity").value;
          let reason = document.getElementById("reason").value;
          if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please input quantity!");
               $("#quantity").focus();
               return;
          }else if(quantity > sold_qty){
               alert("You cannot return more than what was sold!");
               $("#quantity").focus();
               return;
          }else if(reason.length == 0 || reason.replace(/^\s+|\s+$/g, "").length == 0){
               alert("Please input reason for return!");
               $("#reason").focus();
               return;
          }else{
               $.ajax({
                    type : "POST",
                    url : "../controller/return_sales.php",
                    data: {item:item, sales_id:sales_id, user_id:user_id, quantity:quantity, reason:reason, store:store},
                    success : function(response){
                         $("#sales_return").html(response);
                    }
               })
               setTimeout(function(){
                    $("#sales_return").load("sales_return.php #sales_return");
               }, 3000);
               return false
          }
     }else{
          return;
     }
}


// reprint receipt
function printReceipt(invoice){
     // alert(item_id);
     window.open("../controller/print_receipt.php?receipt="+invoice);
     /* $.ajax({
          type : "GET",
          url : "../controller/print_receipt.php?receipt="+invoice,
          success : function(response){
               $("#printReceipt").html(response);
          }
     })
     setTimeout(function(){
          $("#printReceipt").load("print_receipt.php #printReceipt");
     }, 100);
     return false; */
 
 }
// prinit sales receipt for direct sales
function printSalesReceipt(invoice){
     window.open("../controller/sales_receipt.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_receipt.php?receipt="+invoice,
          success : function(response){
               $("#direct_sales").html(response);
          }
     }) */
/*      setTimeout(function(){
          $("#direct_sales").load("direct_sales.php #direct_sales");
     }, 100); */
     return false;
 
 }
// prinit sales receipt for sales order
function printSalesOrderReceipt(invoice){
     window.open("../controller/sales_order_receipt.php?receipt="+invoice);
     showPage('post_sales_order.php');
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_order_receipt.php?receipt="+invoice,
          success : function(response){
               $("#sales_details").html(response);
          }
     }) */
     /* setTimeout(function(){
          $("#direct_sales").load("direct_sales.php #direct_sales");
     }, 100);
     return false; */
 
 }
// prinit sales order ticket
function printSalesTicket(invoice){
     window.open("../controller/sales_order_ticket.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_order_ticket.php?receipt="+invoice,
          success : function(response){
               $("#sales_order").html(response);
          }
     }) */
     setTimeout(function(){
          $("#staff_list").load("new_order.php #staff_list");
     }, 100);
     return false;
 
 }
 //print docket for guest order
function printGuestDocket(invoice){
     window.open("../controller/guest_docket.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_order_ticket.php?receipt="+invoice,
          success : function(response){
               $("#sales_order").html(response);
          }
     }) */
     setTimeout(function(){
          $("#add_bill").load("add_to_guest_bill.php #add_bill");
     }, 100);
     return false;
 
 }
 //perform any type of search with just two date
 function search(url){
     let from_date = document.getElementById('from_date').value;
     let to_date = document.getElementById('to_date').value;
     /* authentication */
     if(from_date.length == 0 || from_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date!");
          $("#from_date").focus();
          return;
     }else if(to_date.length == 0 || to_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#to_date").focus();
          return;
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/"+url,
               data: {from_date:from_date, to_date:to_date},
               beforeSend: function(){
                    $(".new_data").html("<div class='processing'><div class='loader'></div></div>");
               },
               success: function(response){
               $(".new_data").html(response);
               }
          });
     }
     return false;
}
 //perform revenue search on stores with two dates
 function searchRevenueStore(){
     let revenue_store = document.getElementById('revenue_store').value;
     let from_date = document.getElementById('from_date').value;
     let to_date = document.getElementById('to_date').value;
     /* authentication */
     if(from_date.length == 0 || from_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date!");
          $("#from_date").focus();
          return;
     }else if(to_date.length == 0 || to_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#to_date").focus();
          return;
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/search_revenue_store.php",
               data: {from_date:from_date, to_date:to_date, revenue_store:revenue_store},
               success: function(response){
               $(".new_data").html(response);
               }
          });
     }
     return false;
}
 //search dashboard reports
 function searchDashboard(board){
     let store = board;
     /* authentication */
     if(store.length == 0 || store.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a store!");
          $("#store").focus();
          return;
    /*  }else if(from_date.length == 0 || from_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date!");
          $("#from_date").focus();
          return;
     }else if(to_date.length == 0 || to_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#to_date").focus();
          return; */
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/search_dashboard.php",
               data: {store:store},
               success: function(response){
               $("#general_dashboard").html(response);
               }
          });
     }
     return false;
}
//change store
function changeStore(store, user){
     window.open("../controller/change_store.php?store="+store+"&user="+user, "_self");
}
function changeStoreRevenue(store){
     if(store.length == 0 || store.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a store");
          return;
     }else{
          $.ajax({
               type: "GET",
               url: "../controller/get_store_revenue.php?store="+store,
               success : function(response){
                    $(".general_revenue").html(response);
               }
          })
          return false;
     }
     
}
// Post daily expense 
function postExpense(){
     let posted = document.getElementById("posted").value;
     let store = document.getElementById("store").value;
     let exp_date = document.getElementById("exp_date").value;
     let exp_head = document.getElementById("exp_head").value;
     let amount = document.getElementById("amount").value;
     let details = document.getElementById("details").value;
     if(exp_date.length == 0 || exp_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter transaction date!");
          $("#exp_date").focus();
          return;
     }else if(exp_head.length == 0 || exp_head.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select an expense head").focus();
          $("#exp_head").focus();
          return;
     }else if(amount.length == 0 || amount.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input transaction amount");
          $("#amount").focus();
          return;
     }else if(details.length == 0 || details.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter description of transaction");
          $("#details").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/post_expense.php",
               data : {posted:posted, exp_date:exp_date, exp_head:exp_head, amount:amount, details:details, store:store},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#exp_date").val('');
     $("#exp_head").val('');
     $("#amount").val('');
     $("#details").val('');
     $("#exp_date").focus();
     return false;    
}


//add reasons for removal
function addReason(){
     let reason = document.getElementById("reason").value;
     if(reason.length == 0 || reason.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input reason!");
          $("#reason").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_reason.php",
               data : {reason:reason},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#reason").val('');
     $("#reason").focus();
     return false;
}
//  get item history
function getItemHistory(item){
     let from_date = document.getElementById('from_date').value;
     let to_date = document.getElementById('to_date').value;
     let history_item = item;
     /* authentication */
     if(from_date.length == 0 || from_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date!");
          $("#from_date").focus();
          return;
     }else if(to_date.length == 0 || to_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a date range!");
          $("#to_date").focus();
          return;
     }else if(history_item.length == 0 || history_item.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select an item!");
          $("#history_item").focus();
          return;
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/get_history.php",
               data: {from_date:from_date, to_date:to_date, history_item:history_item},
               success: function(response){
               $(".new_data").html(response);
               }
          });
          $("#sales_item").html('');
          $("#history_item").val('');
     }
     return false;
}

// get sub menus to add to rights
function getSubmenu(menu_id){
     let menu = menu_id;
     // alert(menu_id);
     // return;
     if(menu_id){
          $.ajax({
               type : "POST",
               url :"../controller/get_submenu.php",
               data : {menu:menu},
               success : function(response){
                    $("#sub_menu").html(response);
               }
          })
          return false;
     }else{
          $("#sub_menu").html("<option value'' selected>Select a menu first</option>")
     }
     
}
// get user rights
function getRights(user_id){
     let user = user_id;;
     if(user){
          $.ajax({
               type : "POST",
               url :"../controller/get_rights.php",
               data : {user:user},
               success : function(response){
                    $(".rights").html(response);
               }
          })
          return false;
     }else{
          $(".rights").html("<h3>Select a user</h3>")
     }
     
}
//add user rights
function addRights(right){
     let sub_menu = right;
     let menu = document.getElementById("menu").value;
     let user = document.getElementById("user").value;
     if(user.length == 0 || user.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select user!");
          $("#user").focus();
          return;
     }else if(menu.length == 0 || menu.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select a menu!");
          $("#menu").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_right.php",
               data : {user:user, menu:menu, sub_menu:sub_menu},
               success : function(response){
                    $(".info").html(response);
                    getRights(user);
               }              
          })
          return false;
     }

}
//delete right from user
function removeRight(right, user){
     let remove = confirm("Do you want to remove this right from the user?", "");
     if(remove){
          $.ajax({
               type : "GET",
               url : "../controller/delete_right.php?right="+right,
               success : function(response){
                    $(".info").html(response);
                    getRights(user);

               }
          })
     }else{
          return;
     }
}

/* download any table data to excel */
function convertToExcel(table, title){
     $(`#${table}`).table2excel({
          filename: title
     });
}

//show help
/* show frequenty asked questions */
function showFaq(answer){
     let all_answers = document.querySelectorAll(".faq_notes");
     all_answers.forEach(function(notes){
          notes.style.display = "none";
     })
     document.getElementById(answer).style.display = "block";
}

//display items in revenue by category for current date
function viewItems(department_id){
     let department = department_id;
     $.ajax({
          type : "Get",
          url : "../controller/view_revenue_cat_items.php?department="+department,
          success : function(response){
               $(".category_info").html(response);
               document.getElementById("cat_info").scrollIntoView();
          }
     })
     return false;
}
//display items in revenue by category for current date
function viewItemsDate(from, to, department_id){
     let department = department_id;
     $.ajax({
          type : "Get",
          url : "../controller/view_revenue_cat_items_date.php?department="+department+"&from="+from+"&to="+to,
          success : function(response){
               $(".category_info").html(response);
               document.getElementById("cat_info").scrollIntoView();

          }
     })
     return false;
}

//give discount
function giveDiscount(){
     discount = document.getElementById("discount").value;
     discount_invoice = document.getElementById("discount_invoice").value;
     discount_total = document.getElementById("discount_total").value;
     if(discount.replace(/^\s+|\s+$/g, "").length == 0){
          alert("please enter a discount value!");
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/give_discount.php",
               data : {discount_invoice:discount_invoice, discount_total:discount_total, discount},
               success : function(response){
                    $(".sales_order").html(response);
               }
          })
          return false;
     }

}

//delete individual transfered items from transfer
function deleteTransfer(transfer, item){
     let confirmDel = confirm("Are you sure you want to remove this item?", "");
     if(confirmDel){
          
          $.ajax({
               type : "GET",
               url : "../controller/delete_transfer.php?transfer_id="+transfer+"&item_id="+item,
               success : function(response){
                    $(".stocked_in").html(response);
               }
               
          })
          return false;
     }else{
          return;
     }
}

//post transfer
function postTransfer(invoice_number){
     invoice = invoice_number;
     confirmPost = confirm("Are you sure to post this transfer?", "");
     if(confirmPost){
          $.ajax({
               method : "GET",
               url : "../controller/post_transfer.php?invoice="+invoice,
               success : function(response){
                    $("#stockin").html(response);
               }
          })
          return false;
     }else{
          return;
     }
}
//Accept items transferred
function acceptItem(invoice_number){
     invoice = invoice_number;
     confirmPost = confirm("Are you sure to accept this item?", "");
     if(confirmPost){
          $.ajax({
               method : "GET",
               url : "../controller/accept_item.php?transfer_id="+invoice,
               success : function(response){
                    $("#accept_item").html(response);
               }
          })
          setTimeout(function(){
               $("#accept_item").load("accept_items.php #accept_item");
          }, 2000);
          return false
     }else{
          return;
     }
}
//Reject items transferred
function rejectItem(invoice_number){
     invoice = invoice_number;
     confirmPost = confirm("Are you sure to reject this item?", "");
     if(confirmPost){
          $.ajax({
               method : "GET",
               url : "../controller/reject_item.php?transfer_id="+invoice,
               success : function(response){
                    $("#accept_item").html(response);
               }
          })
          setTimeout(function(){
               $("#accept_item").load("accept_items.php #accept_item");
          }, 2000);
          return false
     }else{
          return;
     }
}
//Get stock balance by store
function getStockBalance(store_id){
     store = store_id;
     $.ajax({
          method : "POST",
          url : "../controller/get_stock_balance.php",
          data : {store:store},
          success : function(response){
               $(".store_balance").html(response);
          }
     })
     return false
     
}

// Add new customer
function addCustomer(){
     let customer = document.getElementById("customer").value;
     let phone_number = document.getElementById("phone_number").value;
     let address = document.getElementById("address").value;
     let email = document.getElementById("email").value;
     if(customer.length == 0 || customer.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter customer name!");
          $("#customer").focus();
          return;
     }else if(phone_number.length == 0 || phone_number.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter customer phone number").focus();
          $("#phone_number").focus();
          return;
     }else if(address.length == 0 || address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input customer address");
          $("#address").focus();
          return;
     }else if(email.length == 0 || email.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter customer email address");
          $("#email").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_customer.php",
               data : {customer:customer, phone_number:phone_number, email:email, address:address},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#customer").val('');
     $("#email").val('');
     $("#address").val('');
     $("#phone_number").val('');
     $("#customer").focus();
     return false;    
}

//post other payments
//post other Transfer payments for guest
function postOtherPayment(){
     let mode = document.getElementById("mode").value;
     let posted = document.getElementById("posted").value;
     let customer = document.getElementById("customer").value;
     let invoice = document.getElementById("invoice").value;
     let amount = document.getElementById("amount").value;
     
     $.ajax({
          type : "POST",
          url : "../controller/post_other_payments.php",
          data : {posted:posted, customer:customer, mode:mode, amount:amount, invoice:invoice},
          success : function(response){
               $("#debt_payment").html(response);
          }
     })
     
     return false;    

}

//add menu
function addMenu(){
     let menu = document.getElementById("menu").value;
     if(menu.length == 0 || menu.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input menu!");
          $("#menu").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_menu.php",
               data : {menu:menu},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     $("#menu").val('');
     $("#menu").focus();
     return false;
}
//add sub-menu
function addSubMenu(){
     let menus = document.getElementById("menus").value;
     let sub_menu = document.getElementById("sub_menu").value;
     let sub_menu_url = document.getElementById("sub_menu_url").value;
     if(menus.length == 0 || menus.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select menu!");
          $("#menus").focus();
          return;
     }else if(sub_menu.length == 0 || sub_menu.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input sub-menu!");
          $("#sub_menu").focus();
          return;
     }else if(sub_menu_url.length == 0 || sub_menu_url.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input sub-menu url!");
          $("#sub_menu_url").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/add_sub_menu.php",
               data : {menus:menus, sub_menu:sub_menu, sub_menu_url:sub_menu_url},
               success : function(response){
               $(".info").html(response);
               }
          })
     }
     // $("#menus").val('');
     $("#sub_menu").val('');
     $("#sub_menu_url").val('');
     $("#sub_menu").focus();
     return false;
}
//update submenu details
function updateSubMenu(){
     let sub_menu_id = document.getElementById("sub_menu_id").value;
     let menu = document.getElementById("menu").value;
     let sub_menu = document.getElementById("sub_menu").value;
     let url = document.getElementById("url").value;
     let status = document.getElementById("status").value;
     if(menu.length == 0 || menu.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select menuy!");
          $("#menu").focus();
          return;
     }else if(sub_menu.length == 0 || sub_menu.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input sub-menu!");
          $("#sub_menu").focus();
          return;
     }else if(url.length == 0 || url.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input sub-menu url!");
          $("#url").focus();
          return;
     }else if(status.length == 0 || status.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input sub-menu status!");
          $("#status").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/update_submenu.php",
               data: {sub_menu_id:sub_menu_id, menu:menu, sub_menu:sub_menu, url:url, status:status},
               success : function(response){
                    $("#change_sub_menu").html(response);
               }
          })
          setTimeout(function(){
               $("#change_sub_menu").load("edit_sub_menu.php #change_sub_menu");
          }, 1000);
          return false
     }
 }
 //get customer on key press
function getCustomers(input){
     $("#search_results").show();
     if(input.length >= 3){
          $.ajax({
               type : "POST",
               url : "../controller/get_customer_name.php?input="+input,
               success : function(response){
                    $("#search_results").html(response);
               }
          })
     }
     
}
 //get customer on key press for editing
function getCustomerEdit(input){
     $("#search_results").show();
     if(input.length >= 3){
          $.ajax({
               type : "POST",
               url : "../controller/get_customer_edit.php?input="+input,
               success : function(response){
                    $("#search_results").html(response);
               }
          })
     }
     
}
// update guest details
function updateCustomer(){
     let guest_id = document.getElementById("guest_id").value;
     let last_name = document.getElementById("last_name").value;
     let other_names = document.getElementById("other_names").value;
     let contact_phone = document.getElementById("contact_phone").value;
     let contact_address = document.getElementById("contact_address").value;
     let emergency_contact = document.getElementById("emergency_contact").value;
     let gender = document.getElementById("gender").value;
     if(other_names.length == 0 || other_names.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter Other name!");
          $("#other_names").focus();
          return;
     }else if(last_name.length == 0 || last_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter last name!");
          $("#last_name").focus();
          return;
     }else if(contact_phone.length == 0 || contact_phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter guest phone number").focus();
          $("#contact_phone").focus();
          return;
     }else if(contact_address.length == 0 || contact_address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input guest address");
          $("#address").focus();
          return;
     }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select guest gender");
          $("#gender").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/update_customer.php",
               data : {guest_id:guest_id, last_name:last_name, other_names:other_names, contact_phone:contact_phone, gender:gender, contact_address:contact_address, emergency_contact:emergency_contact},
               success : function(response){
               $("#update_customer").html(response);
               }
          })
          setTimeout(function(){
               $("#edit_customer").load("edit_customer_info.php #edit_customer");
          }, 1500);
     }
     // $("#customer").focus();
     return false;    
}

 //pay debt
 function payDebt(invoice, customer, balance, amount_owed){
     if(parseFloat(amount_owed) > parseFloat(balance)){
          alert("Insufficient balance! Kindly fund customer wallet to continue");
          return;
     }else{
          let confirm_pay = confirm("Are you sure to complete this transaction?", "");
          if(confirm_pay){
               $.ajax({
                    type : "GET",
                    url : "../controller/pay_debt.php?receipt="+invoice+"&customer="+customer+"&amount_owed="+amount_owed,
                    success : function(response){
                         $("#pay_debts").html(response);
                    }
               })
               setTimeout(() => {
                    $("#pay_debts").load("debt_payment.php?customer="+customer + "#pay_debts");
               }, 1500);
               return false;
          }else{
               return;
          }
     }
}

//reverse deposits
function reverseDeposit(deposit, customer){
     let confirm_reverse = confirm("Are you sure you want to reverse this transaction?", "");
     if(confirm_reverse){
          $.ajax({
               type : "GET",
               url : "../controller/reverse_deposit.php?deposit_id="+deposit+"&customer="+customer,
               success : function(response){
                    $("#reverse_dep").html(response);
               }
          })
          setTimeout(() => {
               $("#reverse_dep").load("reverse_deposit.php #reverse_dep");
          }, 1500);
          return false;
          
     }else{
          return;
     }
}
// Fund customer wallet via deposit 
function deposit(){
     let invoice = document.getElementById("invoice").value;
     let posted = document.getElementById("posted").value;
     let customer = document.getElementById("customer").value;
     let store = document.getElementById("store").value;
     let amount = document.getElementById("amount").value;
     let payment_mode = document.getElementById("payment_mode").value;
     let details = document.getElementById("details").value;
     if(payment_mode.length == 0 || payment_mode.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select payment_mode!");
          $("#exp_date").focus();
          return;
     }else if(amount.length == 0 || amount.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input transaction amount");
          $("#amount").focus();
          return;
     }else if(details.length == 0 || details.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter description of transaction");
          $("#details").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/deposit.php",
               data : {posted:posted, customer:customer, payment_mode:payment_mode, amount:amount, details:details, store:store, invoice:invoice},
               success : function(response){
               $("#fund_account").html(response);
               }
          })
     }
     return false;    
}

// prinit deposit receipt for fund wallet
function printDepositReceipt(invoice){
     window.open("../controller/deposit_receipt.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_receipt.php?receipt="+invoice,
          success : function(response){
               $("#direct_sales").html(response);
          }
     }) */
     /* setTimeout(function(){
          $("#direct_sales").load("direct_sales.php #direct_sales");
     }, 100); */
     return false;
 
 }
 //get item to check history
function getHistoryItems(item_name){
     let item = item_name;
     if(item.length >= 3){
          if(item){
               $.ajax({
                    type : "POST",
                    url :"../controller/get_history_items.php",
                    data : {item:item},
                    success : function(response){
                         $("#sales_item").html(response);
                    }
               })
               return false;
          }else{
               $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
          }
     }
     
}
//get price for rooms
function getPrice(check_room){
     let check_in_room = check_room;
     // alert(check_room);
     // return;
     if(check_in_room){
          $.ajax({
               type : "POST",
               url :"../controller/get_price.php",
               data : {check_in_room:check_in_room},
               success : function(response){
                    $("#fee").html(response);
                    calculateDays();
               }
          })
          // $("#room_price").show();
          return false;
     }else{
          $("#amount").html("<p>Please select room first</p>");
     }
     
}
//get price for rooms
function getRoomPrice(check_room){
     let check_in_room = check_room;
     // alert(check_room);
     // return;
     if(check_in_room){
          $.ajax({
               type : "POST",
               url :"../controller/get_room_price.php",
               data : {check_in_room:check_in_room},
               success : function(response){
                    $("#fee").html(response);
               }
          })
          // $("#room_price").show();
          return false;
     }else{
          $("#amount").html("<p>Please select room first</p>");
     }
     
}
// prinit sales receipt for direct sales
function printGuestReceipt(invoice){
     window.open("../controller/guest_receipt.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_receipt.php?receipt="+invoice,
          success : function(response){
               $("#direct_sales").html(response);
          }
     }) */
     /* setTimeout(function(){
          $("#direct_sales").load("direct_sales.php #direct_sales");
     }, 100); */
     return false;
 
 }
// prinit guest bill
function printGuestBill(guest){
     window.open("../controller/guest_bill.php?guest="+guest);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_receipt.php?receipt="+invoice,
          success : function(response){
               $("#direct_sales").html(response);
          }
     }) */
     /* setTimeout(function(){
          $("#direct_sales").load("direct_sales.php #direct_sales");
     }, 100); */
     return false;
 
 }

 //display payment form
 function displayPayment(){
     $("#payment_form").toggle();
 }

 //print customer bill
function printBill(invoice){
     window.open("../controller/print_bill.php?receipt="+invoice);
     // alert(item_id);
     /* $.ajax({
          type : "GET",
          url : "../controller/sales_receipt.php?receipt="+invoice,
          success : function(response){
               $("#direct_sales").html(response);
          }
     }) */
     return false;
 
 }

 //print end of day for current day
function printEndOfDay(){
     // alert(item_id);
     window.open("../controller/print_end_of_day.php");
 }
 //print end of day by date
function printEndOfDayByDate(from, to){
     // alert(item_id);
     window.open("../controller/print_end_of_day_date.php?from="+from+"&to="+to);
 }

 // update room foto 
function updatePhoto(){
     let item = document.getElementById("item").value;
     let photo = document.getElementById("photo").value;
     let pics = document.getElementById("pics").value;
     if(photo.length == 0 || photo.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please upload image");
          $("#photo").focus();
          return;
     }else if(pics.length == 0 || pics.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select photo type");
          $("#foto").focus();
          return;
     }else{
          var fd = new FormData();
          var files = $('#photo')[0].files[0];
          fd.append('photo',files);
          fd.append('item',item);
          fd.append('pics',pics);
         
          $.ajax({
               url: '../controller/update_photo.php',
               type: 'post',
               data: fd,
               contentType: false,
               processData: false,
               success: function(response){
                    if(response != 0){
                    $("#edit_price").html(response); 
                    
                    }else{
                         alert('file not uploaded');
                         return
                    }
               },
          });
          
     }    
     setTimeout(function(){
          $('#edit_price').load("room_price.php #edit_price");
     }, 1500);
     return false;    
}

//add articles
function addArticle(){
     let title = document.getElementById("title").value;
     let details = document.getElementById("details").value;
     let photo = document.getElementById("photo").value;
    
     if(title.length == 0 || title.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter article title")
          $("title").focus();
          return;
     }else if(details.length == 0 || details.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input article details");
          $("#details").focus();
          return;
     
     }else if(photo.length == 0 || photo.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please upload first image");
          $("#photo").focus();
          return;
    
     }else{
          var fd = new FormData();
          var files = $('#photo')[0].files[0];
          fd.append('photo',files);
          fd.append('title',title);
          fd.append('details', details);
          
          $.ajax({
               url: '../controller/add_article.php',
               type: 'post',
               data: fd,
               contentType: false,
               processData: false,
               success: function(response){
                    if(response != 0){
                    $(".info").html(response); 
                   
                    }else{
                         alert('file not uploaded');
                         return
                    }
               },
          });
          
     }
     $("#title").val('');
     $("#title").focus();
     $("#photo").val('');
     $("#details").val('');
     return false;    
}


//update articel
//modify item name
function updateArticle(){
     let article = document.getElementById("article").value;
     let title = document.getElementById("title").value;
     let details = document.getElementById("details").value;
     if(title.length == 0 || title.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input title!");
          $("#title").focus();
          return;
     }else if(details.length == 0 || details.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input article details!");
          $("#details").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/update_article.php",
               data: {article:article, title:title, details:details},
               success : function(response){
                    $("#item_list").html(response);
               }
          })
          setTimeout(function(){
               $("#item_list").load("articles.php #item_list");
          }, 1500);
          return false
     }
 }

 //book room
function booking(){
     let posted_by = document.getElementById("posted_by").value;
     let check_in_category = document.getElementById("check_in_category").value;
     let last_name = document.getElementById("last_name").value;
     let first_name = document.getElementById("first_name").value;
     let email = document.getElementById("email").value;
     let gender = document.getElementById("gender").value;
    
     let contact_address = document.getElementById("contact_address").value;
     let contact_phone = document.getElementById("contact_phone").value;
     
     let check_in_date = document.getElementById("check_in_date").value;
     let check_out_date = document.getElementById("check_out_date").value;
     let room_fee = document.getElementById("room_fee").value;
     let quantity = document.getElementById("quantity").value;
     let amount_due = document.getElementById("amount_due").value;
     let todayDate = new Date();
     let today = todayDate.toLocaleDateString();
     // alert(today);
     if(check_in_category.length == 0 || check_in_category.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room category!");
          $("#check_in_category").focus();
          return;
     
     }else if(last_name.length == 0 || last_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Last Name");
          $("#last_name").focus();
          return;
     }else if(first_name.length == 0 || first_name.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter First Name");
          $("#first_name").focus();
          return;
     }else if(email.length == 0 || email.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter email address");
          $("#email").focus();
          return;
     }else if(gender.length == 0 || gender.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Select Gender");
          $("#gender").focus();
          return;
     
     }else if(contact_address.length == 0 || contact_address.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter contact person's Address");
          $("#contact_address").focus();
          return;
     }else if(contact_phone.length == 0 || contact_phone.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter Guest Phone number");
          $("#contact_phone").focus();
          return;
     }else if(quantity.length == 0 || quantity.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Enter room quantity");
          $("#contact_phone").focus();
          return;
     }else if(check_in_date.length == 0 || check_in_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check in date");
          $("#check_in_date").focus();
          return;
     }else if(check_out_date.length == 0 || check_out_date.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please Input Check out date");
          $("#check_out_date").focus();
          return;
     }else if(new Date(today).getTime() > new Date(check_in_date).getTime()){
          alert("Check in date cannot be lesser than todays date");
          $("#check_in_date").focus();
          return;
     }else if((new Date(check_in_date )).getTime() > (new Date(check_out_date)).getTime()){
          alert("Check in date cannot be greater than check out date");
          $("#check_in_date").focus();
          return;
     }else if(amount_due.length == 0 || amount_due.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select room to display amount");
          $("#category").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/book_room.php",
               data : {posted_by:posted_by,check_in_room:check_in_room, last_name:last_name, first_name:first_name, email:email, quantity:quantity, room_fee:room_fee, gender:gender,contact_address:contact_address, contact_phone:contact_phone, check_in_date:check_in_date, check_out_date:check_out_date, amount_due:amount_due},
               success : function(response){
               $("#check_in").html(response);
               }
          })
          setTimeout(() => {
               $("#check_in").load("book_room.php #check_in");
          }, 2000);
          /* $("#check_in_category").val('');
          $("#check_in_room").val('');
          $("#last_name").val('');
          $("#first_name").val('');
          $("#amount_due").val('');
          $("#check_in_date").val('');
          $("#check_out_date").val('');
          $("#age").val('');
          $("#gender").val('');
          $("#days").html('');
          $("#contact_address").val('');
          $("#contact_phone").val('');
          $("#check_in_category").focus(); */
          return false; 
     }
        
}

//update user role
function updateRole(){
     let user_id = document.getElementById("user_id").value;
     let user_role = document.getElementById("user_role").value;
     if(user_role.length == 0 || user_role.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please select role!");
          $("#user_role").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/change_role.php",
               data: {user_id:user_id, user_role:user_role},
               success : function(response){
                    $("#staff_list").html(response);
               }
          })
          setTimeout(function(){
               $("#staff_list").load("change_role.php #staff_list");
          }, 2000);
          return false
     }
 }

 function applyDiscount(discount, room, id, days){
     $.ajax({
          type : "GET",
          url : "../controller/apply_discount.php?discount="+discount+"&room="+room+"&guest_id="+id+"&days="+days,
          success : function(response){
               $("#all_payments").html(response);
          }
     })
     setTimeout(function(){
          $("#all_payments").load("post_payment.php?guest_id="+id+" #all_payments");
     }, 1500)
 }

 //get customer on key press
function getGuest(input){
     $("#search_results").show();
     if(input.length >= 3){
          customer = input;
          $.ajax({
               type : "POST",
               url : "../controller/get_guests.php",
               data : {customer:customer},
               success : function(response){
                    $("#sales_item").html(response);
               }
          })
     }
     
}

//refund guest fee
function refund(){
     let guest = document.getElementById("guest").value;
     let wallet = document.getElementById("wallet").value;
     let amount = document.getElementById("amount").value;
     if(amount.length == 0 || amount.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount to refund!");
          $("#amount").focus();
          return;
     }else if(amount > wallet){
          alert("Insufficient fund!");
          $("#amount").focus();
          return;
     }else if(amount <= 0){
          alert("Please input value!");
          $("#amount").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/refund_guest.php",
               data : {guest:guest, wallet:wallet, amount:amount},
               success : function(response){
               $("#refund").html(response);
               }
          })
     }
     setTimeout(function(){
          $("#refund").load("guest_refund.php #refund");
     }, 1500);
     return false;
}

//get guest to fund
function getGuestfunding(input){
     $("#search_results").show();
     if(input.length >= 3){
          customer = input;
          $.ajax({
               type : "POST",
               url : "../controller/get_guest_fund.php",
               data : {customer:customer},
               success : function(response){
                    $("#sales_item").html(response);
               }
          })
     }
     
}
//fund guest wallet
function fundGuest(){
     let guest = document.getElementById("guest").value;
     let wallet = document.getElementById("wallet").value;
     let amount = document.getElementById("amount").value;
     if(amount.length == 0 || amount.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please input amount to fund!");
          $("#amount").focus();
          return;
     }else if(amount <= 0){
          alert("Please input a value!");
          $("#amount").focus();
          return;
     }else{
          $.ajax({
               type : "POST",
               url : "../controller/fund_guest.php",
               data : {guest:guest, wallet:wallet, amount:amount},
               success : function(response){
               $("#refund").html(response);
               }
          })
     }
     setTimeout(function(){
          $("#refund").load("fund_wallet.php #refund");
     }, 1500);
     return false;
}

//dispense bar or restaurant order
function dispenseOrder(order_id){
     let order = order_id;
     let confirm_dispense = confirm("Are you sure you have issued out this order?", "");
     if(confirm_dispense){
          $.ajax({
               type : "GET",
               url : "../controller/dispense_order.php?order_id="+order,
               beforeSend: function(){
                    $("#all_orders").html("<div class='processing'><div class='loader'></div></div>");
               },
               success : function(response){
                    $("#all_orders").html(response);
               }
          })
          setTimeout(function(){
               $("#all_orders").load("dispense_order.php #all_orders");
          }, 2000);
     }else{
          return;
     }
}