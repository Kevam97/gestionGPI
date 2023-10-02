<?php

use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\CompanyResource\Pages\CreateCompany;
use App\Models\User;
use Livewire\Livewire;
use function Pest\Laravel\get;
// beforeEach(function(){
//     $this->actingAs(User::factory()->create());
// });

it('can render page', function () {
    login();
    get(CompanyResource::getUrl('index'))->assertSuccessful();

});
