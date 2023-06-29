import { Component, ViewChild } from '@angular/core';
import { FiltersInputs } from './shared/Types';
import { TransactionsTableComponent } from './transactions-table/transactions-table.component';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  @ViewChild('dataTable') dataTable: TransactionsTableComponent;
  title = 'parent-aps';

  filters: FiltersInputs = {
    provider: '*',
    currency: '*',
    status: '*',
    balanceMin: 0,
    balanceMax: 80000,
  };

  async fetchData() {
    await this.dataTable.fetchData();
  }
}
