
<div id="wall"></div>
<!-- Pre loader -------------->
<style>
    :root{--bg-content: 14,15,26;}
    .pre-loader{
        --opacity: 1;
        width: 100vw;
        height: 100vh;
        position: fixed;
        top: 0;
        z-index: 10000;
        display:flex; 
        align-items: center;
        justify-content: center;
        transition: opacity 1s, visibility 1s;
        background-color: rgb(var(--bg-content), var(--opacity))
    }

    .pre-loader .main-content img{
        width: 200px;
    }

    .pre-loader .wrapper-content{
        width: 320px;
        height: 210px;
        transform: translateY(0);
        position: absolute;
        animation: loader 4s linear both;
        background-color: transparent;
    }

    .pre-loader .wrapper-content div{
        --opacity: 0.9;
        width: 100%;
        height: 100%;
        position: relative;
        animation: wave 4s ease-in-out infinite;
        background-color: rgb(var(--bg-content), var(--opacity))
    }

    @keyframes loader {
        0%{
            transform: translateY(0);
        }
        100%{
            transform: translateY(-100%);
        }
    }

    @keyframes wave {
        0%,100%{
            clip-path: polygon(0 100%, 4% 93%, 9% 87%, 14% 83%, 21% 80%, 26% 80%, 31% 82%, 35% 84%, 39% 86%, 44% 88%, 49% 91%, 56% 93%, 63% 94%, 70% 93%, 76% 91%, 81% 89%, 86% 86%, 91% 83%, 95% 79%, 100% 71%, 100% 0, 0 0);
        }
        50%{
            clip-path: polygon(0 78%, 2% 82%, 7% 88%, 13% 91%, 17% 92%, 22% 92%, 27% 92%, 33% 91%, 38% 90%, 45% 89%, 52% 87%, 57% 84%, 63% 81%, 69% 79%, 76% 79%, 81% 80%, 87% 84%, 91% 87%, 96% 93%, 100% 100%, 100% 0, 0 0);    
        }
    }

    .pre-loader.pre-loader-close{
        opacity: 0;
        visibility: hidden;
    }
</style>
<script>
    window.addEventListener("load", () => {
        const loader = document.querySelector(".pre-loader");
        loader.classList.add("pre-loader-close");
        // loader.addEventListener("transitionend", () => {
        //     document.body.removeChild(loader);
        // });
    });
</script>
<!-- Pre loader -------------->


<!-- Pre loader -------------->
<div class="pre-loader">
    <div class="main-content">
        <img src="img/cloud_arm.png" alt="">
    </div>
    <div class="wrapper-content">
        <div></div>
    </div>
</div>
<!-- Pre loader -------------->