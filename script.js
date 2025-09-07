let progressBar = document.createElement('div');
progressBar.classList.add("scroll-progress");
let progress = document.createElement('div');
progress.classList.add('scroll-indicator');
progress.appendChild(progressBar);
document.body.appendChild(progress);
window.addEventListener('scroll', function(){
    let scrollFromTop = window.pageYOffset;
    console.log(`Scrolled down by:${scrollFromTop}`);
    let current_height = document.body.scrollHeight - window.innerHeight;
    const percent = (scrollFromTop / current_height) * 100;

    const run = document.querySelector('.scroll-progress');
    run.style.width = percent + '%';
});


document.querySelectorAll(".blog-tag").forEach(el => {
    el.addEventListener("click", function() {
        let category = (el.innerText).toLowerCase();
        window.location.href = "category.php?category=" + encodeURIComponent(category);
    });
});

document.querySelector(".view").addEventListener("click",function(){
    window.location.href = ""
})
