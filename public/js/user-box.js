class UserBox {

    /**
     * Div com os usuários indicados
     * @param {DOMElement} target Div alvo pra botar os usuários
     * @param {DOMElement} emptyLabel Alvo para mostrar quando a div está vazia
     */
    constructor(target, emptyLabel, onclick) {
        this.list = [];
        this.target = target;
        this.emptyLabel = emptyLabel;

        this.onclick = onclick;
    }

    /**
     * Adiciona usuários na div
     * 
     * @param {Array} users Os usuários
     */
    add(...users) {
main:
        for (let user of users) {

            // Ver se o usuário já não está nessa lista
            for (var item of this.list) {
                if (user.id == item.id) {
                    continue main;
                }
            }

            this.list.push(user);

            var bt = document.createElement('a');
            bt.href = '#!';
            bt.classList.add('list-group-item', 'list-group-item-action');
            bt.innerText = user.name;
            bt.dataset.id = user.id;
            bt.onclick = () => {
                this.onclick(user);
            }

            document.querySelector(this.target).appendChild(bt);
        }

        if (document.querySelector(this.target).children.length > 0) {
            document.querySelector(this.emptyLabel).style.display = 'none';
        }
    }

    clear() {
        this.list = [];

        document.querySelector(this.target).innerHTML = '';
        document.querySelector(this.emptyLabel).style.display = 'inherit';
    }

    remove(...users) {
        for (var user of users) {
            for(var item of document.querySelectorAll(`${this.target} > a`)) {
                if (item.dataset.id == user.id) {
                    // Remover o usuário da lista
                    for (var i in this.list) {
                        if (this.list[i].id == user.id) {
                            this.list.splice(i, 1);
                        }
                    }

                    item.parentElement.removeChild(item);
                    break;
                }
            }
        }

        if (this.list.length <= 0) {
            this.clear();
        }
    }
}