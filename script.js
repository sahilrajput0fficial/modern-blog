let reaction = document.querySelectorAll(".unreact");
    reaction.forEach(function(e){
        e.addEventListener("click",function(){
            if(e.classList.contains("unreact")){
                e.classList.remove("unreact")
                e.classList.add("react");
                e.firstElementChild.classList.remove("fa-regular")
                e.firstElementChild.classList.add("fa-solid");
            }
            else if(e.classList.contains("react")){
                e.classList.remove("react")
                e.classList.add("unreact");
                e.firstElementChild.classList.remove("fa-solid")
                e.firstElementChild.classList.add("fa-regular");
            }

        })
    });