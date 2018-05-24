# Empty Wireframes

This project will be used as the start for creating wireframes.

## Usage

### New project

You can start a project by cloning this repo and removing the `.git`-folder. 

After that you should install the dependencies:

    composer install
    yarn install


### Browsing the wireframes

Browsing the wireframes is done by using PHP's build in webserver:

    php -S 127.0.0.1:8000 -t public

### Creating wireframes

The url for a specific page is based on the structure inside the `templates`-folder. Or better said, our controller
will search for a specific template to render based on the url.

Some examples:

* [http://127.0.0.1/] will render the template `templates/index.html.twig`
* [http://127.0.0.1/dolores] will render the template `templates/dolores.html.twig`
* [http://127.0.0.1/dolores/voluptas] will render the template `templates/dolores/voluptas.html.twig`
* [http://127.0.0.1/dolores/voluptas/nobis-quis] will render the template `templates/dolores/voluptas/nobis-quis.html.twig`
* [http://127.0.0.1/dolores/voluptas/nobis-quis/aliquid-velit] will render the template `templates/dolores/voluptas/nobis-quis/aliquid-velit.html.twig`


### Framework layout

The framework layout can be used for wireframes that will use the framework. In essence you can use the same Twig-blocks 
as they are a copy/paste from the framework.

#### User

The current user is shown at the top, and uses a variable called: `user`, this is an object with the following mandatory
property:

* `email`

Optional you can add a property `role`, which is used for the navigation, see below.

By example:

    {% set user = { 'email': 'alexis17@deprez.org'} %}

#### Navigation

The navigation is included based on the `role`-property of the `user`-object. Per role a file should be placed in 
`templates/_partials/framework/navigation/_$role.twig.html`.

You can use your own logic on how to set the active state for a menu-item. But we advise to check the example.

By example:

    {% set user = {  'role': 'admin',  'email': 'alexis17@deprez.org'} %}
    {% set navigation = {  'active': 'contacts'} %}

### Mails

In some applications mails need to be send. In the wireframes you can add a screen after an action and before the
result is shown.

In this screen you can show the developer and client what the mail needs to contain.

There are some required variables that you need to provide:

* `next_page`, this defines the url for the next page.
* `from`, This defines the sender of the mail, eg: `Advalvas <no-reply@advalvas.be>`.
* `to`, this defines to whom the mail will be send, eg: `Jelle Fiers <jfiers@mathieu.com>`.
* `subject`, this defines the subject of the mail, eg:`This is the subject`.

And some optional variables:

* `cc`, this defines to whom a copy will be send, eg `Kobe Fontaine <kobe.fontaine@advalvas.be>, Sales <sales@advalvas.be>`.
* `bcc`, this defines to whom a blind copy will be send, eg `Administratie <admin@advalvas.be>`.
* `replyTo`, this defines to whom the reply should be send, eg `Administratie <admin@advalvas.be>`.

An examples is available in `templates/examples/mail/mail.html.twig` and can be viewed at 
[/examples/mail/mail](/examples/mail/mail).

### Writing documentation

By default there is a way to write documentation about the wireframes you create. 

#### Menu Generation

The menu on the right is generated automatically.

It will loop all the files in the folder `templates/_docs` and find all `h1`-elements with an `id`-attribute.

You can structure the documentation in folders as you want. The menu-items are sorted based on the filename of the file 
and the order of the `h1`-elements in the file.

All `h2`-elements are added as children of the active menu-item thru javascript.


#### Questions
 
In most cases the wireframes will bring some extra questions on the table, which should be checked with the client. For
this we added an extra `<question>`-element which you can use inside the templates.

    <question>
        This is a question
    </question>

You can add the answer from the client inside the `<question>`-element with a `<answer>`-element:

    <question>
        Is this question answered?
        <answer>
            Yes
        </answer>
    </question>


For an easy overview of all unanswered questions, they are listed on the [index-page](/_docs) of the docs.

#### Todo's

The same is implemented for `<todo>`-elements.

    <todo>
        Check if we have written all documentation
    </todo>
