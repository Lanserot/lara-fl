<?php

namespace Database\Seeders;

use App\Models\User\User;
use Buisness\Order\AddOrderCommand;
use Buisness\Order\ValueObject\OrderVO;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auth::guard('api')->setUser(User::find(10));

        (new AddOrderCommand())
            ->setOrderVo(OrderVO::get(
                '3д бмв',
                '<p>создать модель бмв</p>
                 <p>и шоб дверки открывались</p>',
            ))
            ->setCategoryId(2)
            ->execute();
        (new AddOrderCommand())
            ->setOrderVo(OrderVO::get(
                'Создать новый вк',
                '<p>Ну в общем круто хочу, что бы было, да</p>',
            ))
            ->setCategoryId(3)
            ->execute();
        (new AddOrderCommand())
            ->setOrderVo(OrderVO::get(
                'реализовать покемонов',
                '<p>Ну в общем круто хочу, что бы было, да</p>',
            ))
            ->setCategoryId(1)
            ->execute();
    }
}
