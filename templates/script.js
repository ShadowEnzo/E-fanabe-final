document.addEventListener('DOMContentLoaded', function() {
    // Sidebar responsive
    var hamburger = document.getElementById('tsindry-hamburger');
    var sidebar = document.getElementById('menu-ankavia');
    if (hamburger && sidebar) {
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('miseho');
        });
        // Fermer le menu si on clique en dehors (mobile)
        document.addEventListener('click', function(e){
            if (
                sidebar.classList.contains('miseho') &&
                !sidebar.contains(e.target) &&
                e.target !== hamburger
            ) {
                sidebar.classList.remove('miseho');
            }
        });
    }

    // Dropdown matières (sokajy)
    var sokajyBtn = document.getElementById('sokajy-fianarana');
    var sokajyList = document.getElementById('lisitra-sokajy');
    var chevron = document.getElementById('chevron-sokajy');
    if (sokajyBtn && sokajyList) {
        sokajyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sokajyList.classList.toggle('miseho');
            if (chevron) {
                chevron.classList.toggle('fa-chevron-down');
                chevron.classList.toggle('fa-chevron-up');
            }
        });
        // Fermer le dropdown si on clique ailleurs
        document.addEventListener('click', function(e){
            if (
                sokajyList.classList.contains('miseho') &&
                !sokajyList.contains(e.target) &&
                e.target !== sokajyBtn &&
                (!chevron || e.target !== chevron)
            ) {
                sokajyList.classList.remove('miseho');
                if (chevron && !chevron.classList.contains('fa-chevron-down')) {
                    chevron.classList.add('fa-chevron-down');
                    chevron.classList.remove('fa-chevron-up');
                }
            }
        });
    }
});