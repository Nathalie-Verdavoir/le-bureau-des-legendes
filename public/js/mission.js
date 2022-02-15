//missions_pays_planques_pays
//missions_planques
$(document).on('change', '#missions_pays_planques_pays', function() {
    let $field = $(this)
    let $form = $field.closest('form')
    var origin   = window.location.origin;
   // alert(htmlDoc.getElementsByTagName('label')[0])
    let data = {}
    data['pays'] = $field.val()
    debugger
    $.get(origin+'planques',data).then(function (data) {
        debugger
    })
})