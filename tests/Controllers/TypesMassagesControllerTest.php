<?php

namespace Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTester;
use App\Controllers\TypesMassagesController;
use App\Models\TypeMassageModel;

class TypesMassagesControllerTest extends CIUnitTestCase
{
    use ControllerTester;

    public function testIndex()
    {
        $result = $this->controller(TypesMassagesController::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('TypesMassages/index', $result->getBody());
    }

    public function testCreate()
    {
        $result = $this->controller(TypesMassagesController::class)
            ->execute('create');

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('TypesMassages/create', $result->getBody());
    }

    public function testCreatePost()
    {
        $request = [
            'nom_type' => 'Test Massage',
            'description' => 'This is a test massage type',
            'prix' => '50.00',
        ];

        $result = $this->withRequest($this->request->withMethod('post')->setGlobal('post', $request))
            ->controller(TypesMassagesController::class)
            ->execute('create');

        $this->assertRedirectTo('/TypesMassages');
    }

    public function testCreatePostInvalid()
    {
        $request = [
            'nom_type' => 'T',
            'description' => '',
            'prix' => 'invalid',
        ];

        $result = $this->withRequest($this->request->withMethod('post')->setGlobal('post', $request))
            ->controller(TypesMassagesController::class)
            ->execute('create');

        $this->assertRedirectTo(previous_url());
    }

    public function testEdit()
    {
        $typeMassage = new TypeMassageModel();
        $typeMassage->insert([
            'nom_type' => 'Test Massage',
            'description' => 'This is a test massage type',
            'prix' => '50.00',
        ]);

        $result = $this->controller(TypesMassagesController::class)
            ->execute('edit', $typeMassage->getInsertID());

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('TypesMassages/edit', $result->getBody());
    }

    public function testUpdate()
    {
        $typeMassage = new TypeMassageModel();
        $id = $typeMassage->insert([
            'nom_type' => 'Test Massage',
            'description' => 'This is a test massage type',
            'prix' => '50.00',
        ]);

        $request = [
            'nom_type' => 'Updated Test Massage',
            'description' => 'This is an updated test massage type',
            'prix' => '60.00',
        ];

        $result = $this->withRequest($this->request->withMethod('post')->setGlobal('post', $request))
            ->controller(TypesMassagesController::class)
            ->execute('update', $id);

        $this->assertRedirectTo('/TypesMassages/success');
    }

    public function testDelete()
    {
        $typeMassage = new TypeMassageModel();
        $id = $typeMassage->insert([
            'nom_type' => 'Test Massage',
            'description' => 'This is a test massage type',
            'prix' => '50.00',
        ]);

        $result = $this->controller(TypesMassagesController::class)
            ->execute('delete', $id);

        $this->assertRedirectTo('/TypesMassages');
        $this->assertNull($typeMassage->find($id));
    }

    public function testSuccess()
    {
        $result = $this->controller(TypesMassagesController::class)
            ->execute('success');

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('TypesMassages/success', $result->getBody());
    }
}
