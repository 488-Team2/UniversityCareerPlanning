<!DOCTYPE html>
<html lang="en">
<head>
<title>University Administrator Dashboard</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="adminstyle.css">
<style>* {
    box-sizing: border-box;
  }
  
  body {
    margin: 0;
  }
  
  /* Style the header */
  .header {
    background-color: #f1f1f1;
    padding: 20px;
    text-align: center;
  }
  
  /* Style the top navigation bar */
  .topnav {
    overflow: hidden;
    background-color: #333;
  }
  
  /* Style the topnav links */
  .topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }
  
  /* Change color on hover */
  .topnav a:hover {
    background-color: #ddd;
    color: black;
  }
  
  /* Create three equal columns that floats next to each other */
  .column {
    float: left;
    width: 33.33%;
    padding: 15px;
  }
  
  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }
  .myButton {
    box-shadow:inset 0px 1px 0px 0px #cf866c;
    background:linear-gradient(to bottom, #d0451b 5%, #bc3315 100%);
    background-color:#d0451b;
    border-radius:3px;
    border:1px solid #942911;
    display:block;
    cursor:pointer;
    color:#ffffff;
    font-family:Georgia;
    font-size:20px;
    padding:32px 62px;
    text-decoration:none;
    text-shadow:0px 1px 0px #854629;
  }
  .myButton:hover {
    background:linear-gradient(to bottom, #bc3315 5%, #d0451b 100%);
    background-color:#bc3315;
  }
  .myButton:active {
    position:relative;
    top:1px;
  }
  .btn-container {
    width: 250px;
    position: absolute;
  }
  .center {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
  } </style>
</head>
<body>

<div class="header">
  <h1>University Career Planning</h1>
  <p>Eastern Washington University</p>
</div>

<div class="topnav">
  <a href="http://127.0.0.1:8000/home">Home</a>
  <a href="#">Dashboard</a>
  <a href="http://127.0.0.1:8000/degrees">Degrees</a>
  <a href="#">Logout</a>
</div>

<div class="row">
<div class="center">
<div class="btn-container">
 <a href="http://127.0.0.1:8000/apiDegree" class="myButton">Create New Major</a>
  <a href="#" class="myButton">Import New Major from API </a>
  <a href="#" class="myButton">Update Existing Major</a>
  <a href="#" class="myButton">Update Salary Information from BLS API</a>
</div>
</div>
</div>

</body>
</html>