### To create an action/repository/controller file

```bash
$ php artisan make:file --type=r TaskRepository --m=Task
```

or all in one command

```bash
$ php artisan make:file --type=c TaskController --m=Task && php artisan make:file --type=a TaskAction --m=Task && php artisan make:file --type=r TaskRepository --m=Task
```

--type=c (Controller file)
--type=a (Action file)
--type=r (Repository file)

#### --type= 'a' for Action, 'c' for Controller and 'r' for Repository

#### --m= your model name
