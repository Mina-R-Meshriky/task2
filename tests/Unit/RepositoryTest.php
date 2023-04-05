<?php

it('can get all records from the repository', function () {

    $database = Mockery::mock(\App\Core\Database\Database::class);
    $database->shouldReceive('getMany')
             ->andReturn([
                 [
                     'id' => 1,
                     'col' => 'somevalue',
                 ],
                 [
                     'id' => 2,
                     'col' => 'somevalue2',
                 ],
             ]);

    $repo = new \App\Core\Database\Repository($database, 'sometable');

    expect($repo->all())->toBeArray()->toHaveCount(2);
});

it('can get a certain record from the repository', function () {

    $database = Mockery::mock(\App\Core\Database\Database::class);
    $database->shouldReceive('getOne')
             ->andReturn(
                 [
                     'id' => 1,
                     'col' => 'somevalue',
                     'col2' => 'anothervalue'
                 ],
             );

    $repo = new \App\Core\Database\Repository($database, 'sometable');

    expect($repo->get(2))->toBeArray()->toHaveCount(3);
});

it('can create a record', function () {

    $database = Mockery::mock(\App\Core\Database\Database::class);
    $stmt = Mockery::mock(PDOStatement::class);
    $stmt->shouldReceive('errorCode')->andReturnNull();

    $database->shouldReceive('query')->andReturn($stmt);
    $database->shouldReceive('lastInsertedId')->andReturn(1);

    $repo = new \App\Core\Database\Repository($database, 'sometable');

    expect($repo->create(['col' => 'value']))->toBeInt();
});