import { AfterViewInit, AfterViewChecked, Component, ViewChild, Input, EventEmitter, Output } from '@angular/core';
import { MatTable } from '@angular/material/table';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatSnackBar, MatSnackBarRef } from '@angular/material/snack-bar';
import { TransactionsTableDataSource, TransactionsTableItem } from './transactions-table-datasource';
import { FiltersInputs } from '../shared/Types';

@Component({
  selector: 'app-transactions-table',
  templateUrl: './transactions-table.component.html',
  styleUrls: ['./transactions-table.component.css']
})
export class TransactionsTableComponent implements AfterViewInit, AfterViewChecked {
  @Input() filters: FiltersInputs;
  @Output() fetchedData = new EventEmitter();

  @ViewChild(MatPaginator) paginator!: MatPaginator;
  @ViewChild(MatSort) sort!: MatSort;
  @ViewChild(MatTable) table!: MatTable<TransactionsTableItem>;

  dataSource: TransactionsTableDataSource;

  /** Columns displayed in the table. Columns IDs can be added, removed, or reordered. */
  displayedColumns = [
    'data_provider',
    'parent_amount',
    'parent_id',
    'parent_email',
    'status_code_2',
    'status_code',
    'currency',
    'registeration_date',
  ];

  constructor(private sbar: MatSnackBar) {
    this.dataSource = new TransactionsTableDataSource();
  }

  ngAfterViewInit(): void {
    this.dataSource.sort = this.sort;
    this.dataSource.paginator = this.paginator;
    this.table.dataSource = this.dataSource;

    this.openSnackBar('Fetching data...');

    setTimeout(() => this.fetchData(), 500);
  }

  ngAfterViewChecked(): void {
    this.dataSource.updateFilters(
      this.filters
    );
  }

  openSnackBar(message: string, action = "Cool", duration = 5) {
    this.sbar.open(message, action, {
      duration: duration * 1000,
      horizontalPosition: 'center',
      verticalPosition: 'bottom',
    })
  }

  getStatusCase(statusCode: number) {
    const num = String(statusCode >= 100 ? statusCode / 100 : statusCode);
    const cases = {
      '1': 'authorised',
      '2': 'declined',
      '3': 'refunded',
    };

    return cases[num] || 'unknown';
  }

  async fetchData() {
    let message = 'Data fetched successfully.';

    try {
      const data = await this.dataSource.fetchData();

      if (0 === data.length) {
        message += ' No data matched your criteria..';
      }
    } catch(err) {
      console.warn({err});
      message = 'An error occured while trying to fetch data!';
    }

    this.openSnackBar(message);
  }
}
