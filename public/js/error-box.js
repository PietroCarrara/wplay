/**
 * Abstração para uma div da classe alert-danger do bootstrap
 */
class ErrorBox {
    constructor(target) {
        this.target = target;
    }

    getTarget() {
        return document.querySelector(this.target);
    }

    // Adiciona um ou mais erros no alert
    add(...errors) {
        this.mountAlert();

        console.log(errors);

        for (var err of errors) {
            this.getTarget().innerHTML += err + '<br/>';
        }
    }

    // Transforma o target num alert
    mountAlert() {
        this.getTarget().classList.add('alert', 'alert-danger');
    }

    // Limpa o alert
    clear() {
        this.getTarget().innerHTML = '';
        this.getTarget().classList.remove('alert', 'alert-danger');
    }
}