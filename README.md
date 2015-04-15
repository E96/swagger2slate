# How to create html docs using swagger

* Store your api documentation with your code.
* Update and publish html documentation in couple lines in terminal.

## Document your php api

1. Install Php annotations plugin for PhpStorm (Preferences → Plugins → Browse repositories → PHP Annotation → Install Plugin)
2. Install swagger-php (`composer require zircote/swagger-php=2.*@dev`)
3. Write annotations ([Swagger-php getting started](https://github.com/zircote/swagger-php/blob/2.x/docs/Getting%20started.md))
4. Convert annotations to swagger.json (`./vendor/bin/swagger . -o ./swagger.json`)

## Generate html docs and publish to github

### Requirements
- empty branch gh-pages must exists
- swagger.json in repository
- [bundler](http://bundler.io) (`gem install bundler`)

### Steps

Get slate in your repository
```shell
git clone --depth 1 git@github.com:{your-name}/{your-repository} {your-repository}-docs # create folder to store docs
cd {your-repository}-docs
git remote add slate git@github.com:tripit/slate.git # add slate origin to pull from
git fetch slate
git checkout --orphan slate slate/master # create slate branch with slate/master contents
git commit -m "first slate commit"
```

Prepare slate
```shell
bundle install --path vendor/bundle
echo -e "\nvendor/" >> .gitignore
```

Download [swagger2slate.phar](https://github.com/e96/swagger2slate/releases/latest) to current directory and set execution rights to file
```shell
chmod +x swagger2slate.phar
echo -e "\nswagger2slate.phar/" >> .gitignore
```

Generate slate markdown
```shell
cat ../{your-repository}/swagger.json | ./swagger2slate.phar > source/index.md
```

Preview docs
```shell
bundle exec middleman server
```

Commit changes
```shell
git add -u
git commit -m "api docs update"
```

Publish docs
```shell
bundle exec rake publish
```

Check out your doc: http://{your-name}.github.io/{your-repository}/

#### Resources
* [Swagger specification 2.0](https://github.com/swagger-api/swagger-spec/blob/master/versions/2.0.md)
* [Swagger explained](http://bfanger.github.io/swagger-explained)
* [Doctrine annotations](http://doctrine-common.readthedocs.org/en/latest/reference/annotations.html)
* [Swagger-php getting started](https://github.com/zircote/swagger-php/blob/2.x/docs/Getting%20started.md)
* [Slate](https://github.com/tripit/slate)

> Written with [StackEdit](https://stackedit.io/).