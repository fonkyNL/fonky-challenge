interface PaginationLinkObject {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

interface PaginatedCollection<T> {
  data: T[];
  links: PaginationLinkObject;
  meta: {
    current_page: number;
    from: number;
    last_page: number;
    links: {
      active: boolean;
      label: string;
      url: string | null;
    }[];
    path: string;
    per_page: number;
    to: number;
    total: number;
  };
}

interface LaravelResource<T> {
    data: T,
}

type LaravelCollection<T> = T[];



interface SharedPageProps {
  auth: {
    user: User;
  };
}

interface User {
  id: number;
  name: string;
  email: string;
}

interface Customer {
  id: number;
  name: string;
  created_at: string,
  updated_at: string,
}

interface Branch {
    id: number;
    name: string;
}

interface Employee {
    id: number;
    name: string;
}

interface Product {
    id: number;
    name: string;
}

interface Buyer {
    id: number;
    name: string;
}

interface Order {
    id: number;
    products: LaravelCollection<Product>;
    branch: null|Branch
    employee: null|Employee
    buyer: null|Buyer
    ordered_at: string
}
