window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            
            if($("#toogleButton").hasClass("fa-chevron-left")){
                $("#toogleButton").removeClass("fa-chevron-left");
                $("#toogleButton").addClass("fa-chevron-right");
            }else{
                $("#toogleButton").removeClass("fa-chevron-right");
                $("#toogleButton").addClass("fa-chevron-left");
            }
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
});
