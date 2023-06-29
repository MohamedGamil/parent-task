import axios from 'axios';
import { DataSource } from '@angular/cdk/collections';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { map } from 'rxjs/operators';
import { Observable, of as observableOf, merge, Subject } from 'rxjs';
import { FiltersInputs } from '../shared/Types';

const API_ENDPOINT_URL = 'http://localhost:8000/api/v1/users';

export interface TransactionsTableItem {
  data_provider: string;
  parent_id: string;
  parent_email: string;
  status_code: number;
  parent_amount: number;
  currency: string;
  registeration_date: string;
}

const INIT_DATA: TransactionsTableItem[] = [];

/**
 * Data source for the TransactionsTable view. This class should
 * encapsulate all logic for fetching and manipulating the displayed data
 * (including sorting, pagination, and filtering).
 */
export class TransactionsTableDataSource extends DataSource<TransactionsTableItem> {
  data: TransactionsTableItem[] = INIT_DATA;
  stream$: Subject<TransactionsTableItem[]>;
  filters: FiltersInputs | undefined;
  paginator: MatPaginator | undefined;
  sort: MatSort | undefined;

  constructor() {
    super();

    this.stream$ = new Subject();
  }

  /**
   * Connect this data source to the table. The table will only update when
   * the returned stream emits new items.
   * @returns A stream of the items to be rendered.
   */
  connect(): Observable<TransactionsTableItem[]> {
    if (this.paginator && this.sort) {
      // Combine everything that affects the rendered data into one update
      // stream for the data-table to consume.
      return merge(
          this.stream$,
          this.paginator.page,
          this.sort.sortChange
        )
        .pipe(map(() => {
          return this.getPagedData(this.getSortedData([...this.data ]));
        }));
    } else {
      throw Error('Please set the paginator and sort on the data source before connecting.');
    }
  }

  /**
   *  Called when the table is being destroyed. Use this function, to clean up
   * any open connections or free any held resources that were set up during connect.
   */
  disconnect(): void {
    this.stream$.unsubscribe();
  }

  async updateFilters(filters: FiltersInputs) {
    const filters_ = {
      provider: '*' !== filters.provider
        ? filters.provider
        : null,

      currency: '*' !== filters.currency
        ? filters.currency
        : null,

      status: '*' !== filters.status
        ? filters.status
        : null,

      balanceMin: filters.balanceMin >= 0
        ? filters.balanceMin
        : null,

      balanceMax: filters.balanceMax < Number.MAX_SAFE_INTEGER
        ? filters.balanceMax
        : null,
    };

    this.filters = filters_;
  }

  async fetchData() {
    const params = { ...this.filters };
    const res = await axios.get(API_ENDPOINT_URL, { params });

    this.data = res.data.data || [];
    this.pushUpdate();

    return this.data;
  }

  private async pushUpdate() {
    this.stream$.next(
      this.data
    );

    console.log('Data fetched: ', {...this.data});
  }

  /**
   * Paginate the data (client-side). If you're using server-side pagination,
   * this would be replaced by requesting the appropriate data from the server.
   */
  private getPagedData(data: TransactionsTableItem[]): TransactionsTableItem[] {
    if (this.paginator) {
      const startIndex = this.paginator.pageIndex * this.paginator.pageSize;

      return data.splice(startIndex, this.paginator.pageSize);
    } else {
      return data;
    }
  }

  /**
   * Sort the data (client-side). If you're using server-side sorting,
   * this would be replaced by requesting the appropriate data from the server.
   */
  private getSortedData(data: TransactionsTableItem[]): TransactionsTableItem[] {
    if (!this.sort || !this.sort.active || this.sort.direction === '') {
      return data;
    }

    return data.sort((a, b) => {
      const isAsc = this.sort?.direction === 'asc';

      switch (this.sort?.active) {
        case 'data_provider':
          return compare(a.data_provider, b.data_provider, isAsc);

        case 'parent_amount':
          return compare(+a.parent_amount, +b.parent_amount, isAsc);

        default:
          return 0;
      }
    });
  }
}

/** Simple sort comparator for example ID/Name columns (for client-side sorting). */
function compare(a: string | number, b: string | number, isAsc: boolean): number {
  return (a < b ? -1 : 1) * (isAsc ? 1 : -1);
}
