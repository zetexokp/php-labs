<?php

declare(strict_types=1);

function obshchayaSumma(array $rashody): float
{
    $total = 0.0;

    foreach ($rashody as $rashod) {
        $total += (float) $rashod["summa"];
    }

    return $total;
}

function summaNaCheloveka(float $total, int $uchastniki): float
{
    return $total / $uchastniki;
}

function statusByudzheta(float $byudzhet, float $total): string
{
    if ($total < $byudzhet) {
        return "Бюджета достаточно. Осталось: "
            . formatSum($byudzhet - $total) . " " . VALYUTA;
    } elseif ($total === $byudzhet) {
        return "Бюджет использован полностью";
    } else {
        return "Бюджет превышен. Сумма превышения: "
            . formatSum($total - $byudzhet) . " " . VALYUTA;
    }
}

function samyyBolshoyRashod(array $rashody): ?array
{
    if ($rashody === []) {
        return null;
    }

    $maksimalnyy = $rashody[0];

    foreach ($rashody as $rashod) {
        if ($rashod["summa"] > $maksimalnyy["summa"]) {
            $maksimalnyy = $rashod;
        }
    }

    return $maksimalnyy;
}

function rashodyOtSummy(array $rashody, float $minimum): array
{
    $rezultat = [];

    foreach ($rashody as $rashod) {
        if ($rashod["summa"] >= $minimum) {
            $rezultat[] = $rashod;
        }
    }

    return $rezultat;
}

function formatSum(float $summa): string
{
    return number_format($summa, 2, ".", " ");
}

function h(string $tekst): string
{
    return htmlspecialchars($tekst, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
