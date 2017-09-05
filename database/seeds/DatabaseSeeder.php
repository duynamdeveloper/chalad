<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       Model::unguard();
		
		//$this->call(AdminUserTableSeeder::class); // Newly Added Class
		
        $this->call(CountryListTableSeeder::class);

        $this->call(CurrencyTableSeeder::class);

      //  $this->call(DebtorMasterTableSeeder::class); // Newly Added Class

      //  $this->call(CustomerBranchTableSeeder::class); // Newly Added Class

        $this->call(EmailConfigTableSeeder::class);
        
        $this->call(EmailTempDetailsTableSeeder::class);

        $this->call(InvoicePaymentTermsTableSeeder::class); 

      //  $this->call(ItemCodeTableSeeder::class); // Newly Added Class

        $this->call(ItemTaxTypesTableSeeder::class);

        $this->call(ItemUnitTableSeeder::class);

        $this->call(LocationTableSeeder::class);

     //   $this->call(PaymentHistoryTableSeeder::class); // Newly Added Class

        $this->call(PaymentTermsTableSeeder::class);

        $this->call(PreferenceTableSeeder::class);

     //   $this->call(PurchasePriceTableSeeder::class); // Newly Added Class

     //   $this->call(PurchaseOrderTableSeeder::class); // Newly Added Class 

      //  $this->call(PurchaseOrderDetailTableSeeder::class); // Newly Added Class 

      //  $this->call(SalesOrderTableSeeder::class); // Newly Added Class                

      //  $this->call(SalesOrderDetailTableSeeder::class); // Newly Added Class 

        $this->call(SalesTypesTableSeeder::class);

       // $this->call(SalesPriceTableSeeder::class); // Newly Added Class

        $this->call(SecurityRoleTableSeeder::class);

       // $this->call(ShipmentTableSeeder::class); // Newly Added Class

       // $this->call(ShipmentDetailTableSeeder::class); // Newly Added Class

        $this->call(StockCategoryTableSeeder::class);

       // $this->call(StockMasterTableSeeder::class); // Newly Added Class

       // $this->call(StockTransferTableSeeder::class); // Newly Added Class

        //$this->call(SupplierTableSeeder::class); // Newly Added Class

        //$this->call(StockMoveTableSeeder::class); // Newly Added Class

    }
}
