//missions_pays_planques_pays
//missions_planques

$(document).on('change', '#missions_pays_planques_pays', function() {
    let $field = $(this)
    let $form = $field.closest('form')
    let data = {}
    data[$field.attr('name')] = $field.val()
    $.post($form.attr('action'),data).then(function (data) {
        debugger
    })
})