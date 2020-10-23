# Тестовое задание

Установить advanced шаблон Yii2 фреймворка, в backend-приложении реализовать следующий закрытый функционал (доступ в backend-приложение должен производиться только по паролю, сложного разделения прав не требуется):

Написать класс/объект Apple с хранением яблок в БД MySql следуя ООП парадигме.

Функции
- упасть
- съесть ($percent - процент откушенной части)
- удалить (когда полностью съедено)

Переменные
- цвет (устанавли¬вается при создании объекта случайным)
- дата появления (устанавли¬вается при создании объекта случайным unixTmeStamp)
- дата падения (устанавли¬вается при падении объекта с дерева)
- статус (на дереве / упало)
- сколько съели (%)
- другие необходимые переменные, для определени¬я состояния.

Состояния
- висит на дереве
- упало/лежит на земле
- гнилое яблоко

Условия
Пока висит на дереве - испортиться не может.
Когда висит на дереве - съесть не получится.
После лежания 5 часов - портится.
Когда испорчено - съесть не получится.
Когда съедено - удаляется из массива яблок.

Пример результирующего скрипта:
$apple = new Apple('green');

echo $apple->color; // green

$apple->eat(50); // откусить пол яблока
echo $apple->size; // 0.5 - decimal

$apple->fallToGround(); // упасть на землю
$apple->eat(25); // откусить четверть яблока
echo $apple->size; // 0,75

На странице в приложении должны быть отображены все яблоки, которые на этой же странице можно сгенерировать в случайном кол-ве соответствующей кнопкой.
Рядом с каждым яблоком должны быть реализованы кнопки или формы соответствующие функциям (упасть, съесть  процент…) в задании.
Задача не имеет каких-либо ограничений и требований. Все подходы к ее решению определяют¬ способност¬ь выбора правильног¬о алгоритма при проектиров¬ании системы и умение предусмотреть любые возможности развития алгоритма. Задание должно быть выложено в репозиторий на gitHub, с сохранением истории коммитов. Креативность только приветствуется.

