<div class="loader-ball-outer-block">
    <div class="loader-ball-inner-block">
        <div class="loader-ball-group">
            <div class="loader-ball-outer" id="loader-ball-1">
                <div class="loader-ball-inner"></div>
            </div>
            <div class="loader-ball-outer" id="loader-ball-2">
                <div class="loader-ball-inner"></div>
            </div>
            <div class="loader-ball-outer" id="loader-ball-3">
                <div class="loader-ball-inner"></div>
            </div>
            <div class="loader-ball-outer" id="loader-ball-4">
                <div class="loader-ball-inner"></div>
            </div>
            <div class="loader-ball-outer" id="loader-ball-5">
                <div class="loader-ball-inner"></div>
            </div>            
        </div>
    </div>
</div>
<style>
    .loader-ball-outer-block{height: 100%;opacity: 0.9;position: fixed;width: 100%;z-index: 9999999;}
    .loader-ball-inner-block {    
        height: 60px;
        left: 48%;
        margin-left: -17px;
        margin-top: -17px;
        top: 50%;
        width: 60px;
        position: absolute;
    }
    .loader-ball-group {
        position: relative;
        width: 56px;
        height:56px;
        margin:auto;
    }

    .loader-ball-group .loader-ball-outer {
        position: absolute;
        width: 53px;
        height: 53px;
        opacity: 0;
        transform: rotate(225deg);
        -o-transform: rotate(225deg);
        -ms-transform: rotate(225deg);
        -webkit-transform: rotate(225deg);
        -moz-transform: rotate(225deg);
        animation: orbit 6.96s infinite;
        -o-animation: orbit 6.96s infinite;
        -ms-animation: orbit 6.96s infinite;
        -webkit-animation: orbit 6.96s infinite;
        -moz-animation: orbit 6.96s infinite;
    }

    .loader-ball-group .loader-ball-outer .loader-ball-inner{
        position: absolute;
        width: 7px;
        height: 7px;
        background: rgb(25,52,120);
        left:0px;
        top:0px;
        border-radius: 7px;
    }

    .loader-ball-group #loader-ball-1 {
        animation-delay: 1.52s;
        -o-animation-delay: 1.52s;
        -ms-animation-delay: 1.52s;
        -webkit-animation-delay: 1.52s;
        -moz-animation-delay: 1.52s;
    }

    .loader-ball-group #loader-ball-2 {
        animation-delay: 0.3s;
        -o-animation-delay: 0.3s;
        -ms-animation-delay: 0.3s;
        -webkit-animation-delay: 0.3s;
        -moz-animation-delay: 0.3s;
    }

    .loader-ball-group #loader-ball-3 {
        animation-delay: 0.61s;
        -o-animation-delay: 0.61s;
        -ms-animation-delay: 0.61s;
        -webkit-animation-delay: 0.61s;
        -moz-animation-delay: 0.61s;
    }

    .loader-ball-group #loader-ball-4 {
        animation-delay: 0.91s;
        -o-animation-delay: 0.91s;
        -ms-animation-delay: 0.91s;
        -webkit-animation-delay: 0.91s;
        -moz-animation-delay: 0.91s;
    }

    .loader-ball-group #loader-ball-5 {
        animation-delay: 1.22s;
        -o-animation-delay: 1.22s;
        -ms-animation-delay: 1.22s;
        -webkit-animation-delay: 1.22s;
        -moz-animation-delay: 1.22s;
    }



    @keyframes orbit {
        0% {
            opacity: 1;
            z-index:99;
            transform: rotate(180deg);
            animation-timing-function: ease-out;
        }

        7% {
            opacity: 1;
            transform: rotate(300deg);
            animation-timing-function: linear;
            origin:0%;
        }

        30% {
            opacity: 1;
            transform:rotate(410deg);
            animation-timing-function: ease-in-out;
            origin:7%;
        }

        39% {
            opacity: 1;
            transform: rotate(645deg);
            animation-timing-function: linear;
            origin:30%;
        }

        70% {
            opacity: 1;
            transform: rotate(770deg);
            animation-timing-function: ease-out;
            origin:39%;
        }

        75% {
            opacity: 1;
            transform: rotate(900deg);
            animation-timing-function: ease-out;
            origin:70%;
        }

        76% {
            opacity: 0;
            transform:rotate(900deg);
        }

        100% {
            opacity: 0;
            transform: rotate(900deg);
        }
    }

    @-o-keyframes orbit {
        0% {
            opacity: 1;
            z-index:99;
            -o-transform: rotate(180deg);
            -o-animation-timing-function: ease-out;
        }

        7% {
            opacity: 1;
            -o-transform: rotate(300deg);
            -o-animation-timing-function: linear;
            -o-origin:0%;
        }

        30% {
            opacity: 1;
            -o-transform:rotate(410deg);
            -o-animation-timing-function: ease-in-out;
            -o-origin:7%;
        }

        39% {
            opacity: 1;
            -o-transform: rotate(645deg);
            -o-animation-timing-function: linear;
            -o-origin:30%;
        }

        70% {
            opacity: 1;
            -o-transform: rotate(770deg);
            -o-animation-timing-function: ease-out;
            -o-origin:39%;
        }

        75% {
            opacity: 1;
            -o-transform: rotate(900deg);
            -o-animation-timing-function: ease-out;
            -o-origin:70%;
        }

        76% {
            opacity: 0;
            -o-transform:rotate(900deg);
        }

        100% {
            opacity: 0;
            -o-transform: rotate(900deg);
        }
    }

    @-ms-keyframes orbit {
        0% {
            opacity: 1;
            z-index:99;
            -ms-transform: rotate(180deg);
            -ms-animation-timing-function: ease-out;
        }

        7% {
            opacity: 1;
            -ms-transform: rotate(300deg);
            -ms-animation-timing-function: linear;
            -ms-origin:0%;
        }

        30% {
            opacity: 1;
            -ms-transform:rotate(410deg);
            -ms-animation-timing-function: ease-in-out;
            -ms-origin:7%;
        }

        39% {
            opacity: 1;
            -ms-transform: rotate(645deg);
            -ms-animation-timing-function: linear;
            -ms-origin:30%;
        }

        70% {
            opacity: 1;
            -ms-transform: rotate(770deg);
            -ms-animation-timing-function: ease-out;
            -ms-origin:39%;
        }

        75% {
            opacity: 1;
            -ms-transform: rotate(900deg);
            -ms-animation-timing-function: ease-out;
            -ms-origin:70%;
        }

        76% {
            opacity: 0;
            -ms-transform:rotate(900deg);
        }

        100% {
            opacity: 0;
            -ms-transform: rotate(900deg);
        }
    }

    @-webkit-keyframes orbit {
        0% {
            opacity: 1;
            z-index:99;
            -webkit-transform: rotate(180deg);
            -webkit-animation-timing-function: ease-out;
        }

        7% {
            opacity: 1;
            -webkit-transform: rotate(300deg);
            -webkit-animation-timing-function: linear;
            -webkit-origin:0%;
        }

        30% {
            opacity: 1;
            -webkit-transform:rotate(410deg);
            -webkit-animation-timing-function: ease-in-out;
            -webkit-origin:7%;
        }

        39% {
            opacity: 1;
            -webkit-transform: rotate(645deg);
            -webkit-animation-timing-function: linear;
            -webkit-origin:30%;
        }

        70% {
            opacity: 1;
            -webkit-transform: rotate(770deg);
            -webkit-animation-timing-function: ease-out;
            -webkit-origin:39%;
        }

        75% {
            opacity: 1;
            -webkit-transform: rotate(900deg);
            -webkit-animation-timing-function: ease-out;
            -webkit-origin:70%;
        }

        76% {
            opacity: 0;
            -webkit-transform:rotate(900deg);
        }

        100% {
            opacity: 0;
            -webkit-transform: rotate(900deg);
        }
    }

    @-moz-keyframes orbit {
        0% {
            opacity: 1;
            z-index:99;
            -moz-transform: rotate(180deg);
            -moz-animation-timing-function: ease-out;
        }

        7% {
            opacity: 1;
            -moz-transform: rotate(300deg);
            -moz-animation-timing-function: linear;
            -moz-origin:0%;
        }

        30% {
            opacity: 1;
            -moz-transform:rotate(410deg);
            -moz-animation-timing-function: ease-in-out;
            -moz-origin:7%;
        }

        39% {
            opacity: 1;
            -moz-transform: rotate(645deg);
            -moz-animation-timing-function: linear;
            -moz-origin:30%;
        }

        70% {
            opacity: 1;
            -moz-transform: rotate(770deg);
            -moz-animation-timing-function: ease-out;
            -moz-origin:39%;
        }

        75% {
            opacity: 1;
            -moz-transform: rotate(900deg);
            -moz-animation-timing-function: ease-out;
            -moz-origin:70%;
        }

        76% {
            opacity: 0;
            -moz-transform:rotate(900deg);
        }

        100% {
            opacity: 0;
            -moz-transform: rotate(900deg);
        }
    }
</style>