<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeActivity;
use App\Models\Salesman;
use App\Models\Accountant;
use App\Models\WareHouse;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\Lead;
use Carbon\Carbon;

class EmployeeActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Get first seller's employees
        $salesman = Salesman::first();
        $accountant = Accountant::first();
        $warehouse = WareHouse::first();
        $deliveryman = DeliveryMan::first();

        if (!$salesman) {
            $this->command->info('No employees found. Please create employees first.');
            return;
        }

        $sellerId = $salesman->seller_id;
        $order = Order::where('seller_id', $sellerId)->first();
        $lead = Lead::where('seller_id', $sellerId)->first();

        // Sample activities for Salesman
        if ($salesman) {
            $activities = [
                [
                    'activity_type' => 'lead_converted',
                    'description' => 'Converted lead to customer',
                    'reference_type' => $lead ? get_class($lead) : null,
                    'reference_id' => $lead ? $lead->id : null,
                    'created_at' => Carbon::now()->subHours(2),
                ],
                [
                    'activity_type' => 'lead_assigned',
                    'description' => 'Assigned lead to team member',
                    'reference_type' => $lead ? get_class($lead) : null,
                    'reference_id' => $lead ? $lead->id : null,
                    'created_at' => Carbon::now()->subHours(5),
                ],
                [
                    'activity_type' => 'lead_updated',
                    'description' => 'Updated lead status to in progress',
                    'reference_type' => $lead ? get_class($lead) : null,
                    'reference_id' => $lead ? $lead->id : null,
                    'created_at' => Carbon::now()->subHours(8),
                ],
            ];

            foreach ($activities as $activity) {
                EmployeeActivity::create([
                    'seller_id' => $sellerId,
                    'employee_type' => 'salesman',
                    'employee_id' => $salesman->id,
                    'activity_type' => $activity['activity_type'],
                    'description' => $activity['description'],
                    'reference_type' => $activity['reference_type'],
                    'reference_id' => $activity['reference_id'],
                    'metadata' => ['sample' => true],
                    'created_at' => $activity['created_at'],
                ]);
            }
        }

        // Sample activities for Accountant
        if ($accountant) {
            $activities = [
                [
                    'activity_type' => 'invoice_generated',
                    'description' => 'Generated invoice for order #' . ($order ? $order->id : '1'),
                    'reference_type' => $order ? get_class($order) : null,
                    'reference_id' => $order ? $order->id : null,
                    'created_at' => Carbon::now()->subHours(3),
                ],
                [
                    'activity_type' => 'payment_processed',
                    'description' => 'Processed payment for order #' . ($order ? $order->id : '1'),
                    'reference_type' => $order ? get_class($order) : null,
                    'reference_id' => $order ? $order->id : null,
                    'created_at' => Carbon::now()->subHours(6),
                ],
            ];

            foreach ($activities as $activity) {
                EmployeeActivity::create([
                    'seller_id' => $sellerId,
                    'employee_type' => 'accountant',
                    'employee_id' => $accountant->id,
                    'activity_type' => $activity['activity_type'],
                    'description' => $activity['description'],
                    'reference_type' => $activity['reference_type'],
                    'reference_id' => $activity['reference_id'],
                    'metadata' => ['sample' => true],
                    'created_at' => $activity['created_at'],
                ]);
            }
        }

        // Sample activities for Warehouse
        if ($warehouse) {
            $activities = [
                [
                    'activity_type' => 'product_dispatched',
                    'description' => 'Dispatched order #' . ($order ? $order->id : '1') . ' via courier',
                    'reference_type' => $order ? get_class($order) : null,
                    'reference_id' => $order ? $order->id : null,
                    'created_at' => Carbon::now()->subHours(4),
                ],
            ];

            foreach ($activities as $activity) {
                EmployeeActivity::create([
                    'seller_id' => $sellerId,
                    'employee_type' => 'warehouse',
                    'employee_id' => $warehouse->id,
                    'activity_type' => $activity['activity_type'],
                    'description' => $activity['description'],
                    'reference_type' => $activity['reference_type'],
                    'reference_id' => $activity['reference_id'],
                    'metadata' => ['sample' => true],
                    'created_at' => $activity['created_at'],
                ]);
            }
        }

        // Sample activities for Deliveryman
        if ($deliveryman) {
            $activities = [
                [
                    'activity_type' => 'delivery_completed',
                    'description' => 'Delivered order #' . ($order ? $order->id : '1') . ' to customer',
                    'reference_type' => $order ? get_class($order) : null,
                    'reference_id' => $order ? $order->id : null,
                    'created_at' => Carbon::now()->subHours(1),
                ],
            ];

            foreach ($activities as $activity) {
                EmployeeActivity::create([
                    'seller_id' => $sellerId,
                    'employee_type' => 'deliveryman',
                    'employee_id' => $deliveryman->id,
                    'activity_type' => $activity['activity_type'],
                    'description' => $activity['description'],
                    'reference_type' => $activity['reference_type'],
                    'reference_id' => $activity['reference_id'],
                    'metadata' => ['sample' => true],
                    'created_at' => $activity['created_at'],
                ]);
            }
        }

        $this->command->info('Employee activities seeded successfully!');
    }
}
