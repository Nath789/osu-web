<?php

// Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
// See the LICENCE file in the repository root for full licence text.

namespace Tests\Libraries\Multiplayer;

use App\Exceptions\InvariantException;
use App\Libraries\Multiplayer\Mod;
use App\Libraries\Multiplayer\Ruleset;
use Tests\TestCase;

class ModTest extends TestCase
{
    public function testModSettings()
    {
        $settings = Mod::filterSettings(Mod::WIND_UP, ['initial_rate' => '1']);

        $this->assertSame(1.0, $settings->initial_rate);
    }

    public function testModSettingsInvalid()
    {
        $this->expectException(InvariantException::class);
        Mod::filterSettings(Mod::WIND_UP, ['x' => '1']);
    }

    public function testParseInputArray()
    {
        $input = [['acronym' => Mod::WIND_UP, 'settings' => []]];
        $parsed = Mod::parseInputArray($input, Ruleset::OSU);

        $this->assertSame(1, count($parsed));
        $this->assertSame(0, count((array) $parsed[0]->settings));
        $this->assertSame(Mod::WIND_UP, $parsed[0]->acronym);
    }

    public function testParseInputArrayInvalidMod()
    {
        $input = [['acronym' => 'XYZ', 'settings' => []]];

        $this->expectException(InvariantException::class);
        Mod::parseInputArray($input, Ruleset::OSU);
    }

    public function testParseInputArrayWithSettings()
    {
        $input = [['acronym' => Mod::WIND_UP, 'settings' => ['initial_rate' => '1']]];
        $parsed = Mod::parseInputArray($input, Ruleset::OSU);

        $this->assertSame(1, count($parsed));
        $this->assertSame(1, count((array) $parsed[0]->settings));
        $this->assertSame(1.0, $parsed[0]->settings->initial_rate);
        $this->assertSame(Mod::WIND_UP, $parsed[0]->acronym);
    }

    public function testParseInputArrayWithSettingsInvalid()
    {
        $input = [['acronym' => Mod::WIND_UP, 'settings' => ['x' => '1']]];

        $this->expectException(InvariantException::class);
        Mod::parseInputArray($input, Ruleset::OSU);
    }

    public function testValidForRulesetWithValid()
    {
        // This test feels a bit silly and is more implementation-testing than anything...
        // ...consider it a sanity check I guess?

        foreach (Ruleset::ALL as $ruleset) {
            foreach (Mod::validityByRuleset()[$ruleset] as $mod) {
                $this->assertTrue(Mod::validForRuleset($mod, $ruleset));
            }
        }
    }

    public function testValidForRulesetWithInvalid()
    {
        // osu standard
        // enabling a mania-only mod should fail
        $this->assertFalse(Mod::validForRuleset('9K', Ruleset::OSU));

        // taiko
        // enabling a osu standard specific mod should fail
        $this->assertFalse(Mod::validForRuleset('AP', Ruleset::TAIKO));

        // enabling a mania specific mod should fail
        $this->assertFalse(Mod::validForRuleset('9K', Ruleset::TAIKO));

        // catch
        // enabling a osu standard specific mod should fail
        $this->assertFalse(Mod::validForRuleset('AP', Ruleset::CATCH));

        // enabling a mania specific mod should fail
        $this->assertFalse(Mod::validForRuleset('9K', Ruleset::CATCH));

        // mania
        // enabling a osu standard specific mod should fail
        $this->assertFalse(Mod::validForRuleset('AP', Ruleset::MANIA));
    }

    /**
     * @dataProvider modCombos
     */
    public function testValidateSelection($ruleset, $modCombo, $isValid)
    {
        if (!$isValid) {
            $this->expectException(InvariantException::class);
        }

        $result = Mod::validateSelection($modCombo, $ruleset);

        if ($isValid) {
            $this->assertTrue($result);
        }
    }

    public function modCombos()
    {
        return [
            // valid
            [Ruleset::OSU, ['HD', 'DT'], true],
            [Ruleset::OSU, ['HD', 'HR'], true],
            [Ruleset::OSU, ['HD', 'HR'], true],
            [Ruleset::OSU, ['HD', 'NC'], true],

            [Ruleset::TAIKO, ['HD', 'NC'], true],
            [Ruleset::TAIKO, ['HD', 'DT'], true],
            [Ruleset::TAIKO, ['HD', 'HR'], true],
            [Ruleset::TAIKO, ['HR', 'PF'], true],

            [Ruleset::CATCH, ['HD', 'HR'], true],
            [Ruleset::CATCH, ['HD', 'PF'], true],
            [Ruleset::CATCH, ['HD', 'SD'], true],
            [Ruleset::CATCH, ['HD'], true],
            [Ruleset::CATCH, ['EZ'], true],

            [Ruleset::MANIA, ['DT', 'PF'], true],
            [Ruleset::MANIA, ['NC', 'SD'], true],
            [Ruleset::MANIA, ['6K', 'HD'], true],
            [Ruleset::MANIA, ['4K', 'HT'], true],

            // invalid
            [Ruleset::OSU, ['5K'], false],
            [Ruleset::OSU, ['DS'], false],
            [Ruleset::OSU, ['HD', 'HD'], false],
            [Ruleset::OSU, ['RX', 'PF'], false],

            [Ruleset::TAIKO, ['AP'], false],
            [Ruleset::TAIKO, ['RD', 'SD'], false],
            [Ruleset::TAIKO, ['RX', 'PF'], false],

            [Ruleset::CATCH, ['4K'], false],
            [Ruleset::CATCH, ['AP'], false],
            [Ruleset::CATCH, ['RX', 'PF'], false],

            [Ruleset::MANIA, ['AP'], false],
            [Ruleset::MANIA, ['FI', 'HD'], false],
            [Ruleset::MANIA, ['RX', 'PF'], false],
        ];
    }
}
