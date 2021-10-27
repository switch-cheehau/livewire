<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Livewire\Livewire;

class WireablesCanBeSetAsPublicPropertiesTest extends TestCase
{
    /** @test */
    public function a_wireable_can_be_set_as_a_public_property()
    {
        if (version_compare(PHP_VERSION, '7.4', '<')) {
            $this->markTestSkipped('Typed Property Initialization not supported prior to PHP 7.4');
        }

        require_once __DIR__.'/WireablesCanBeSetAsPublicPropertiesStubs.php';

        $wireable = new WireableClass($message = Str::random(), $embeddedMessage = Str::random());

        Livewire::test(ComponentWithWireablePublicProperty::class, ['wireable' => $wireable])
            ->assertSee($message)
            ->assertSee($embeddedMessage)
            ->call('$refresh')
            ->assertSee($message)
            ->assertSee($embeddedMessage)
            ->call('removeWireable')
            ->assertDontSee($message)
            ->assertDontSee($embeddedMessage);
    }
}
