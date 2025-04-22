
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';


/* datapiker options */
$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
    icons: {
        time: 'fas fa-clock',
        date: 'fas fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-check-o',
        clear: 'fas fa-trash',
        close: 'fas fa-times'
    },
    locale: 'pt-br.js',
    tooltips: {
        today: 'Hoje',
        clear: 'Limpar seleção',
        close: 'Fechar',
        selectMonth: 'Selecionar o mês',
        prevMonth: 'Mês anterior',
        nextMonth: 'Próximo mês',
        selectYear: 'Selecionar o ano',
        prevYear: 'Ano anterior',
        nextYear: 'Próximo ano',
        selectDecade: 'Selecionar a década',
        prevDecade: 'Década anterior',
        nextDecade: 'Próxima década',
        prevCentury: 'Século anterior',
        nextCentury: 'Próximo século',
        incrementHour: 'Incrementar hora',
        pickHour: 'Selecionar a hora',
        decrementHour:'Decrementar hora',
        incrementMinute: 'Incrementar minuto',
        pickMinute: 'Selecionar o minuto',
        decrementMinute:'Decrementar minuto',
        incrementSecond: 'Incrementar segundo',
        pickSecond: 'Selecionar o segundo',
        decrementSecond:'Decrementar segundo'
    } });

window.Vue = require('vue');
Vue.prototype.$csrf_token = $('meta[name="csrf-token"]').attr('content');

Vue.filter('toCurrency2', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2
    });
    return formatter.format(value);
});

Vue.filter('toCurrency3', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 3
    });
    return formatter.format(value);
});

Vue.filter('toDecimal2', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2
    });
    return formatter.format(value);
});

Vue.filter('toDecimal3', function (value) {
    if (typeof value !== "number") {
        value = value.toString();
    }
    var formatter = new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 3
    });
    return formatter.format(value);
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*
const app = new Vue({
    el: '#app'
}); 
*/


