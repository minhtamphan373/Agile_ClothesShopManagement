    <!-- -----------------------SLlDER---------------------------------------------- -->
    <section class="sliders">
            <div class="aspect-ratio-169 sliders-img">
                <img src="image/slide1.jpg" alt="">
                <img src="image/slide2.jpg" alt="">
                <img src="image/slide3.jpg" alt="">
            </div>
            <div class="dot-container">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
           </div>
    </section>
    <!-- -----------------------------------slider----------------------- -->

    <script>
    const imgPosition = document.querySelectorAll(".aspect-ratio-169 img")
    const imgContainer = document.querySelector(".aspect-ratio-169")
    const dotItem = document.querySelectorAll(".dot")
    let imgNuber = imgPosition.length
    let index = 0

    imgPosition.forEach(function(image, index){
        image.style.left = index*100 + "%"
        dotItem[index].addEventListener("click",function(){
            slider(index)
        })
    })

    function imgSlide(){
        index++;
        console.log(index)
        if(index>=imgNuber) {index = 0}
        slider (index)
    }
    function slider (index){
        imgContainer.style.left = "-" +index*100+ "%"
        const dotActive = document.querySelector(".active")
        dotActive.classList.remove("active")
        dotItem[index].classList.add("active")
    }
    setInterval(imgSlide,3500)
</script>