<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>Update Candidate Address</title>
   
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
            margin: 8px 0;
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
        <header>Update Address</header>

        <form class="secActive" action="" enctype="multipart/form-data" method="post">
            <div class="form second">
                <div class="details address">
                    <span class="title">Permanent Address Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" name="pa_address" value="<?= set_value('pa_address'); ?>" placeholder="Enter Address Lane 1">
                            <?= form_error('pa_address', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Address Landmark</label>
                            <input type="text" name="pa_address_landmark" value="<?= set_value('pa_address_landmark'); ?>" placeholder="Enter Address Landmark">
                            <?= form_error('pa_address_landmark', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>City</label>
                            <input type="text" name="pa_city" value="<?= set_value('pa_city'); ?>" placeholder="Enter City">
                            <?= form_error('pa_city', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>District</label>
                            <input type="text" name="pa_dist" value="<?= set_value('pa_dist'); ?>" placeholder="Enter District">
                            <?= form_error('pa_dist', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>State</label>
                            <select name="pa_state">
                              <option value="Bihar">Bihar</option>
                              <option value="Assam">Assam</option>
                              <option value="Haryana">Haryana</option>
                              <option value="Madhya Pradesh">Madhya Pradesh</option>
                              <option value="Odisha">Odisha</option>
                              <option value="Gujarat">Gujarat</option>
                              <option value="Delhi">Delhi</option>
                              <option value="Punjab">Punjab</option>
                              <option value="Rajasthan">Rajasthan</option>
                              <option value="Uttarakhand">Uttarakhand</option>
                              <option value="Uttar Pradesh">Uttar Pradesh</option>
                              <option value="West Bengal">West Bengal</option>
                              <option value="Andhra Pradesh">Andhra Pradesh</option>
                              <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                              <option value="Chhattisgarh">Chhattisgarh</option>
                              <option value="Jharkhand">Jharkhand</option>
                              <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                              <option value="Himachal Pradesh">Himachal Pradesh</option>
                            </select>
                            <?= form_error('pa_state', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Pincode</label>
                            <input type="number" maxlength="6" name="pa_pin" value="<?= set_value('pa_pin'); ?>" placeholder="Enter District">
                            <?= form_error('pa_pin', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    </div>
                    <span class="title">Current Address Details</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>Address</label>
                            <input type="text" name="ca_address" value="<?= set_value('ca_address'); ?>" placeholder="Enter Address Lane 1">
                            <?= form_error('ca_address', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Address Landmark</label>
                            <input type="text" name="ca_address_landmark" value="<?= set_value('ca_address_landmark'); ?>" placeholder="Enter Address Landmark">
                            <?= form_error('ca_address_landmark', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>City</label>
                            <input type="text" name="ca_city" value="<?= set_value('ca_city'); ?>" placeholder="Enter City">
                            <?= form_error('ca_city', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>District</label>
                            <input type="text" name="ca_dist" value="<?= set_value('ca_dist'); ?>" placeholder="Enter District">
                            <?= form_error('ca_dist', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>State</label>
                            <select name="ca_state">
                              <option value="Bihar">Bihar</option>
                              <option value="Assam">Assam</option>
                              <option value="Haryana">Haryana</option>
                              <option value="Madhya Pradesh">Madhya Pradesh</option>
                              <option value="Odisha">Odisha</option>
                              <option value="Gujarat">Gujarat</option>
                              <option value="Delhi">Delhi</option>
                              <option value="Punjab">Punjab</option>
                              <option value="Rajasthan">Rajasthan</option>
                              <option value="Uttarakhand">Uttarakhand</option>
                              <option value="Uttar Pradesh">Uttar Pradesh</option>
                              <option value="West Bengal">West Bengal</option>
                              <option value="Andhra Pradesh">Andhra Pradesh</option>
                              <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                              <option value="Chhattisgarh">Chhattisgarh</option>
                              <option value="Jharkhand">Jharkhand</option>
                              <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                              <option value="Himachal Pradesh">Himachal Pradesh</option>
                            </select>
                            <?= form_error('ca_state', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <div class="input-field">
                            <label>Pincode</label>
                            <input type="number" maxlength="6" name="ca_pin" value="<?= set_value('ca_pin'); ?>" placeholder="Enter District">
                            <?= form_error('ca_pin', '<div class="text-danger">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="buttons">                        
                        <button class="sumbit" type="submit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>