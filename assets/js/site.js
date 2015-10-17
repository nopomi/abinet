$(document).ready(function () {
    $('#preview').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var name = button.data('name');
    var deadline = button.data('deadline');
    var description = button.data('description');
    var accepted = button.data('accepted');
    var acceptancerate = button.data('acceptancerate');
    var city = button.data('city');
    var extent = button.data('extent');
    var institutions = button.data('institutions');
    var modal = $(this);
    modal.find('.modal-title').text(name);
    
    document.getElementById('extent').innerHTML = extent + " ECTS";
    document.getElementById('deadline').innerHTML = deadline;
    document.getElementById('description').innerHTML = description;
    document.getElementById('accepted').innerHTML = accepted;
    document.getElementById('acceptancerate').innerHTML = acceptancerate*100 + " %";
    document.getElementById('city').innerHTML = city;
    document.getElementById('institutions').innerHTML = institutions;
    
    });
});