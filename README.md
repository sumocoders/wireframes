# Empty Wireframes

This project will be used as the start for creating wireframes.

## Usage

### New project

You can start a project by cloning this repo and removing the `.git`-folder.

### Browsing the wireframes

Browsing the wireframes is done by using PHP's build in webserver:

    php -S 127.0.0.1:8000 -t public

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
