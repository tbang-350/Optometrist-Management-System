<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_creation_and_approval()
    {
        // 1. Setup Data
        $user = User::factory()->create(['location_id' => 1]);
        $this->actingAs($user);

        $category = Category::create([
            'name' => 'Test Category',
            'created_by' => $user->id,
            'location_id' => 1,
        ]);

        $product = Product::create([
            'name' => 'Test Product',
            'category_id' => $category->id,
            'quantity' => 50,
            'location_id' => 1,
            'created_by' => $user->id,
            'supplier_name' => 'Test Supplier'
        ]);

        $data = [
            'invoice_no' => 1001,
            'date' => '2025-01-01',
            'description' => 'Test Invoice',
            'category_id' => [$category->id],
            'product_id' => [$product->id],
            'selling_qty' => [2],
            'unit_price' => [100],
            'selling_price' => [200],
            'estimated_amount' => 200,
            'paid_status' => 'full_paid',
            'payment_option' => 'cash',
            'discount_amount' => 0,
            'markup_amount' => 0,
            'customer_id' => '0',
            'name' => 'John Doe',
            'phonenumber' => '1234567890',
            'address' => '123 Main St',
            'age' => 30,
            'sex' => 'male',
        ];

        // 2. Perform Create
        $invoiceService = new InvoiceService();
        $invoice = $invoiceService->createInvoice($data);

        // Assert Invoice Created
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'invoice_no' => 1001,
            'status' => '0',
            'location_id' => 1,
        ]);

        // Assert Customer Created
        $this->assertDatabaseHas('customers', [
            'name' => 'John Doe',
            'location_id' => 1,
        ]);

        // Assert Payment Created
        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'paid_status' => 'full_paid',
            'paid_amount' => 200,
        ]);

        // 3. Perform Approve
        $invoiceDetail = $invoice->invoice_details()->first();
        $sellingQuantities = [
            $invoiceDetail->id => 2
        ];

        $invoiceService->approveInvoice($invoice->id, $sellingQuantities);

        // Assert Invoice Status updated
        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'status' => '1',
        ]);

        // Assert Stock Decremented
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 48,
        ]);
    }
}
