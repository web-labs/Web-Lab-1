document.addEventListener("DOMContentLoaded", function (){
        const themeSwitch = document.getElementById("themeSwitch");
        themeSwitch.addEventListener("click", function (event){
            const theme = event.target.checked ? "dark" : "light";
            document.documentElement.setAttribute("data-theme", theme);
            drawCoordsPlane(0);
        });
})