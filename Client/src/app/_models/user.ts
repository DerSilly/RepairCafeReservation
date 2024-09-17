export interface User {
  id: number;
  name: string;
  password: string;
  email: string;
  firstName: string;
  lastName: string;
  phoneNumber?: string; // Optional property
  note: string | null;
  isDeleted: boolean;
  token: string;
  roles: string[];
}
