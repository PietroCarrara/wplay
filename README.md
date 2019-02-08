# Um gerenciador de projetos escrito em Laravel

## Descrição

No sistema, projetos podem ser criados por administradores, que deverá associá-lo a um cliente. Projetos possuem um registro
de usuários, que pode ser gerenciado também por administradores. Portanto, parq que um usuário simples entre em algum projeto,
deverão ser convidados antes. Administradores também podem declarar um projeto como encerrado, caso queiram.

Dentro de um projeto, usuários que participem dele podem criar tarefas discutir o que deve ser feito em cada uma, através de
comentários. Também é possível encerrar tarefas, contanto que metade (arredondando para cima) ou mais da equipe vote nesta opção,
concluindo a discussão. Usuários podem sair e entrar a vontade de tarefas em projetos que participam.

O sistema também gera relatórios para usuários e projetos, informando os pontos batidos pelo usuário, quantas tarefas foram
completas em dado período de tempo, quantas pessoas trabalham no projeto...

Essa não é a descrição mais detalhada ou amigável, mas ajuda a não se perder muito.

## Ferramentas Laravel usadas

- *Observavles*: O sistema registra em logs tudo o que os usuários fazem, e essas logs são criadas quase que exclusivamente
em eventos de observables (salvo o login/registro de usuários)
- *Gates*
- *Database Seeders*
- *Console Commands*

Depois de rodar as migrations e seedar o sistema, você ainda não terá um usuário admin, e mesmo que crie uma conta pelo sistema,
ele será um usuário normal. Para ajudar com isso, você pode usar o comando `make:root` para criar um usuário privilegiado. O
comando foi pensado para ser usado apenas uma vez, já que depois é possível conceder privilégios à outras contas.

```
php artisan migrate
php artisan db:seed
php artisan make:root {email} {senha} {nome}
```

### Prêmio de problema mais cabuloso:

Com certeza o maior desafio nesse projeto foi fazer observables para tabelas pivot. Como era necessário registrar eventos como
"fulano entrou para o projeto tal", as tabelas pivot deveriam disparar eventos "created" e "deleted", mas o Laravel não faz isso
por default. No final a solução ficou relativamente boa, escrevi uma classe que sobrescreve alguns métodos da relação
BelongsToMany e um trait para que as models pudessem usá-la.

---

PS: Não há nada demais no .env, somente sendo diferente do default do laravel as credenciais para acesso ao banco.
