<?php

declare(strict_types=1);

require __DIR__ . "/data.php";
require_once __DIR__ . "/functions.php";

$total = obshchayaSumma($rashody);
$maksimalnyyRashod = samyyBolshoyRashod($rashody);
$krupnyeRashody = rashodyOtSummy($rashody, 1000);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($napravlenie) ?> - бюджет поездки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            line-height: 1.4;
        }

        main {
            max-width: 900px;
        }

        header, section {
            margin-bottom: 30px;
        }

        h1, h2 {
            color: darkblue;
        }

        .card {
            border: 1px solid #cccccc;
            padding: 8px;
            margin-bottom: 8px;
        }

        .label {
            display: inline-block;
            min-width: 190px;
        }

        .value {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eeeeee;
        }

        .status {
            background-color: #f5f5f5;
        }

        .empty {
            color: #666666;
        }
    </style>
</head>
<body>
<main>
    <header>
        <h1><?= h($napravlenie) ?></h1>
        <p>Приложение «Бюджет поездки»</p>
        <div class="meta">
            <div class="card">
                <span class="label">Автор</span>
                <span class="value"><?= h($avtor) ?></span>
            </div>
            <div class="card">
                <span class="label">Группа</span>
                <span class="value"><?= h($gruppa) ?></span>
            </div>
            <div class="card">
                <span class="label">Участники</span>
                <span class="value"><?= $uchastniki ?></span>
            </div>
            <div class="card">
                <span class="label">Бюджет группы</span>
                <span class="value"><?= formatSum((float) $byudzhet) ?> <?= VALYUTA ?></span>
            </div>
            <div class="card">
                <span class="label">Версия PHP</span>
                <span class="value"><?= PHP_VERSION ?></span>
            </div>
        </div>
    </header>

    <section>
        <h2>Расходы группы</h2>
        <?php if ($rashody === []): ?>
            <p class="empty">Список расходов пуст.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Название расхода</th>
                        <th>Категория</th>
                        <th>Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rashody as $index => $rashod): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= h((string) $rashod["nazvanie"]) ?></td>
                            <td><?= h((string) $rashod["kategoriya"]) ?></td>
                            <td><?= formatSum((float) $rashod["summa"]) ?> <?= VALYUTA ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <p><strong>Количество расходов:</strong> <?= count($rashody) ?></p>
    </section>

    <section>
        <h2>Результаты расчётов</h2>
        <div class="results">
            <div class="card">
                <span class="label">Общая стоимость</span>
                <span class="value"><?= formatSum($total) ?> <?= VALYUTA ?></span>
            </div>
            <div class="card">
                <span class="label">Стоимость на человека</span>
                <?php if ($uchastniki > 0): ?>
                    <span class="value"><?= formatSum(summaNaCheloveka($total, $uchastniki)) ?> <?= VALYUTA ?></span>
                <?php else: ?>
                    <span class="value">Некорректное количество участников</span>
                <?php endif; ?>
            </div>
        </div>
        <p class="card status"><strong><?= h(statusByudzheta((float) $byudzhet, $total)) ?></strong></p>
    </section>

    <section>
        <h2>Дополнительная обработка</h2>
        <?php if ($maksimalnyyRashod !== null): ?>
            <p>
                <strong>Самый большой расход:</strong>
                <?= h((string) $maksimalnyyRashod["nazvanie"]) ?> -
                <?= formatSum((float) $maksimalnyyRashod["summa"]) ?> <?= VALYUTA ?>
            </p>
        <?php else: ?>
            <p class="empty">Невозможно определить самый большой расход: список пуст.</p>
        <?php endif; ?>

        <h3>Расходы от 1 000 <?= VALYUTA ?> включительно</h3>
        <?php if ($krupnyeRashody === []): ?>
            <p class="empty">Расходов от 1 000 <?= VALYUTA ?> нет.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($krupnyeRashody as $rashod): ?>
                    <li>
                        <?= h((string) $rashod["nazvanie"]) ?> -
                        <?= formatSum((float) $rashod["summa"]) ?> <?= VALYUTA ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
