<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>Candidate Registration Form</title>
   
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4070f4;
        }
        .container{
            position: relative;
            max-width: 900px;
            width: 100%;
            border-radius: 6px;
            padding: 30px;
            margin: 0 15px;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        .container header{
            position: relative;
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }
        .container header::before{
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            height: 3px;
            width: 27px;
            border-radius: 8px;
            background-color: #4070f4;
        }
        .container form{
            position: relative;
            margin-top: 16px;
            min-height: 490px;
            background-color: #fff;
            overflow: hidden;
        }
        .container form .form{
            position: absolute;
            background-color: #fff;
            transition: 0.3s ease;
        }
        .container form .form.second{
            opacity: 0;
            pointer-events: none;
            transform: translateX(100%);
        }
        form.secActive .form.second{
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }
        form.secActive .form.first{
            opacity: 0;
            pointer-events: none;
            transform: translateX(-100%);
        }
        .container form .title{
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 500;
            margin: 6px 0;
            color: #333;
        }
        .container form .fields{
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        form .fields .input-field{
            display: flex;
            width: calc(100% / 3 - 15px);
            flex-direction: column;
            margin: 4px 0;
        }
        .input-field label{
            font-size: 12px;
            font-weight: 500;
            color: #2e2e2e;
        }
        .input-field input, select, .input-text{
            outline: none;
            font-size: 12px;
            font-weight: 400;
            color: #333;
            border-radius: 5px;
            border: 1px solid #aaa;
            padding: 0 15px;
            height: 30px;
            margin: 8px 0px 0px 0px;
        }
        .input-field input :focus,
        .input-field select:focus{
            box-shadow: 0 3px 6px rgba(0,0,0,0.13);
        }
        .input-field select,
        .input-field input[type="date"]{
            color: #707070;
        }
        .input-field input[type="date"]:valid{
            color: #333;
        }

        .input-text {
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .container form button, .backBtn{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 45px;
            max-width: 200px;
            width: 100%;
            border: none;
            outline: none;
            color: #fff;
            border-radius: 5px;
            margin: 25px 0;
            background-color: #4070f4;
            transition: all 0.3s linear;
            cursor: pointer;
        }
        .container form .btnText{
            font-size: 14px;
            font-weight: 400;
        }
        form button:hover{
            background-color: #265df2;
        }
        form button i,
        form .backBtn i{
            margin: 0 6px;
        }
        form .backBtn i{
            transform: rotate(180deg);
        }
        form .buttons{
            display: flex;
            align-items: center;
        }
        form .buttons button , .backBtn{
            margin-right: 14px;
        }

        @media (max-width: 750px) {
            .container form{
                overflow-y: scroll;
            }
            .container form::-webkit-scrollbar{
               display: none;
            }
            form .fields .input-field{
                width: calc(100% / 2 - 15px);
            }
        }

        @media (max-width: 550px) {
            form .fields .input-field{
                width: 100%;
            }
        }

        .d-none {
            display: none;
        }

        .disabled {
            background-color: rgba(239, 239, 239, 0.3);
        }

        .text-danger {
            color: #f00;
            font-size: 13px;
        }
    </style>
   
</head>
<body>
    <div class="container">
        <header>Registration</header>

        <form action="#" enctype="multipart/form-data" method="post">
            <div class="form first">
                <div class="details personal">
                    <!-- <span class="title">Personal Details</span> -->

                    <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" name="firstname" placeholder="Enter first name" value="<?= set_value('firstname'); ?>">
                            <?= form_error('firstname', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Middle Name</label>
                            <input type="text" name="middlename" placeholder="Enter middle name" value="<?= set_value('middlename'); ?>">
                            <?= form_error('middlename', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" name="lastname" placeholder="Enter last name" value="<?= set_value('lastname'); ?>">
                            <?= form_error('lastname', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="text" name="email" value="<?= set_value('email'); ?>" placeholder="Enter your email">
                            <?= form_error('email', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" name="phone" value="<?= set_value('phone'); ?>" placeholder="Enter mobile number">
                            <?= form_error('phone', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="gender">
                                <option hidden selected>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Others</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Highest Qualification</label>
                            <select name="highest_qualification">
                                <option value="" hidden selected>Enter highest qualification</option>
                                <option value="10th Pass">10th Pass</option>
                                <option value="12th pass">12th pass</option>
                                <option value="10th + ITI">10th + ITI</option>
                                <option value="12+ ITI">12+ ITI</option>
                                <option value="B.A">B.A</option>
                                <option value="B.COM">B.COM</option>
                                <option value="BBA">BBA</option>
                                <option value="BCA">BCA</option>
                                <option value="B.SC">B.SC</option>
                                <option value="B.TECH">B.TECH</option>
                                <option value="MBA">MBA</option>
                                <option value="MCA">MCA</option>
                                <option value="M.A">M.A</option>
                                <option value="M.COM">M.COM</option>
                            </select>
                            <?= form_error('highest_qualification', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" name="password" value="" placeholder="Enter password">
                            <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Confirm Password</label>
                            <input type="password" name="passconf" value="" placeholder="Enter confirm password">
                            <?= form_error('passconf', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Business Unit</label>
                            <select name="company_id">
                                <option hidden selected>Select Business Unit</option>
                                <?php foreach ($business_units as $key => $obj) { ?>
                                    <option value="<?= $obj['id']; ?>"><?= $obj['company_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <div class="fields">
                        <div class="input-field">
                            <label for="ac-pic">Aadhaar Card Front Page</label>
                            <input type="file" name="aadhaar_card_front_pic" class="d-none" id="ac-pic">
                            <div class="input-text" id="cac-pic">Choose file</div>
                            <?= form_error('aadhaar_card_front_pic', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label for="pc-pic">Pan Card</label>
                            <input type="file" name="pancard_pic" class="d-none" id="pc-pic">
                            <div class="input-text" id="cpc-pic">Choose file</div>
                            <?= form_error('pancard_pic', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label for="pp-pic">Voter ID Card</label>
                            <input type="file" name="voter_id" class="d-none" id="pp-pic">
                            <div class="input-text" id="cpp-pic">Choose file</div>
                            <?= form_error('voter_id', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    </div>

                    <button class="nextBtn" type="submit">
                        <span class="btnText">Next</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#cac-pic', function(e) {
            e.preventDefault();
            $("label[for='ac-pic']").trigger('click');
        });

        $("#ac-pic").on('change', function() {
            var filename = $(this).val().split('\\').pop();
            $("#cac-pic").text(filename);
        });

        $(document).on('click', '#cpc-pic', function(e) {
            e.preventDefault();
            $("label[for='pc-pic']").trigger('click');
        });

        $("#pc-pic").on('change', function() {
            var filename = $(this).val().split('\\').pop();
            $("#cpc-pic").text(filename);
        });

        $(document).on('click', '#cpp-pic', function(e) {
            e.preventDefault();
            $("label[for='pp-pic']").trigger('click');
        });

        $("#pp-pic").on('change', function() {
            var filename = $(this).val().split('\\').pop();
            $("#cpp-pic").text(filename);
        });

        // const form = document.querySelector("form"),
        // nextBtn = form.querySelector(".nextBtn"),
        // backBtn = form.querySelector(".backBtn"),
        // allInput = form.querySelectorAll(".first input");

        // nextBtn.addEventListener("click", ()=> {
        //     allInput.forEach(input => {
        //         if(input.value != ""){
        //             form.classList.add('secActive');
        //         }else{
        //             form.classList.remove('secActive');
        //         }
        //     })
        // })

        // backBtn.addEventListener("click", () => form.classList.remove('secActive'));
    </script>
</body>
</html>