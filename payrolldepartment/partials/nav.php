
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<div class="nav">
            <div class="logo">
                <span class="logo-img">
                    <a href="home.php"><img src="Images/Logo.png" alt=""></a>
                </span>
                <span>
                    Payroll Management System
                </span>
            </div>
            <div class="nav-cont">
                <ul>
                    <li class="emp" id="navs">
                        <a href="employee.php">Employee Records</a>
                    </li>
                    <li class="pay" id="navs">
                        <a href="payroll.php">Payroll</a>
                    </li>
                    <li class="tax" id="navs">
                        <a href="tax.php">Tax</a>
                    </li>
                    <li class="salary" id="navs">
                        <a href="salary.php">Salary</a>
                    </li>
                    <li class="logout" id="navs">
                        <a href="loginform.php"><i class="fas fa-sign-out-alt"></i> </a>
                    </li>
                </ul>
            </div>
        </div>


<style>
    div.nav{
    position: relative;
    width: 100%;
    height: 4rem;
    background-color: rgb(31, 31, 31, .9);
    display: flex;
    padding: .8rem 0;
}

div.nav div{
    width: fit-content;
    margin: 0 auto;
}

div.nav div:first-child{
    margin-left: 0;
}

div.nav div:last-child{
    margin-right: 0;
}

div.nav div.logo{
    padding: .2rem 0;
    display: flex;
    margin-left: 50px;
}

div.nav div.logo span{
    display: block;
    width: fit-content;
    height: 100%;
    align-content: center;
    padding: 0 .4rem;
}

div.nav div.logo span:last-child{
    color: #fdfdfd;
    font-weight: 600;
    font-size: 1.5rem;
}

div.nav div.logo span:first-child img{
    width: 100%;
    height: 100%;
    object-fit: contain;

}

div.nav div.nav-cont{
    position: relative;
    width: fit-content;
    align-content: center;
    margin-right: 50px;
}

div.nav div.nav-cont ul{
    list-style-type: none;
    display: flex;
    padding: 0 1rem;
}

div.nav div.nav-cont ul li{
    margin: 0 .5rem;
    display: block;
}

div.nav div.nav-cont ul li a{
    text-decoration: none;
    font-weight: normal;
    font-size: 1.2rem;
    display: block;
    height: fit-content;
    width: fit-content;
    padding: .5rem;
    white-space: nowrap;
    color: #fdfdfd;
    align-content: center;
}

div.nav div.nav-cont ul li.active a{
    color: #BF9819;
}
div.nav div.nav-cont ul li a:hover {
    color: #ffd755; 
    transition: color 0.3s ease; 
}


</style>