$(function () {
    $('.cep').mask('00000-000', {clearIfNotMatch: true});
    $('.letters').mask('S', {translation: {'S': {pattern: /[a-zA-Z\s]/, recursive: true}}});
});
