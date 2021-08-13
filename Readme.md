## Technical exercise for Arcadia.

API specifications are provided in [open-api.yaml](open-api.yaml) file.

Translation is handled by Google Translate library _“stichoza/google-translate-php”_

Configuring data filename through environment variable:
```
DATA_FILE=../var/data/questions.csv
```

Configuring data repository in **services.yaml**
```
App\Repository\QuestionRepositoryInterface: '@question_repository.csv'
#or
App\Repository\QuestionRepositoryInterface: '@question_repository.json'
```
