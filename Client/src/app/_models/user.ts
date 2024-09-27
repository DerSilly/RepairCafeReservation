export interface User {
  id: number;
  name: string;
  email?: string;
  password:string;
  firstName: string;
  lastName: string;
  phoneNumber?: string;
  note?: string;
  isDeleted: boolean;
  token: string;
  roles: string[];
}
