<?php

namespace Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class TestHelperTrimestre extends TestCase
{
    public function testDateSemestre1()
    {
        Carbon::setTestNow('2020-02-01');
        $trimestre = trimestre();
        self::assertTrue($trimestre['inicio'] == '2020-01-01');
        self::assertTrue($trimestre['fim'] == (new Carbon())->setMonth(3)->lastOfMonth()->toDateString());
    }

    public function testDateSemestre2()
    {
        Carbon::setTestNow('2020-05-01');
        $trimestre = trimestre();
        self::assertTrue($trimestre['inicio'] == '2020-04-01');
        self::assertTrue($trimestre['fim'] == (new Carbon())->setMonth(6)->lastOfMonth()->toDateString());
    }

    public function testDateSemestreViradaDeAno()
    {
        Carbon::setTestNow('2020-01-01');
        $trimestre = trimestre();
        self::assertTrue($trimestre['inicio'] == '2019-10-01');
        self::assertTrue($trimestre['fim'] == (new Carbon())->setYear(2019)->setMonth(12)->lastOfMonth()->toDateString());
    }
}
