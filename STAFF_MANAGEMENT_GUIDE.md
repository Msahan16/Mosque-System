# Staff Management System Documentation

## Overview
The Staff Management System allows mosque administrators to add staff members with specific permissions, controlling which pages and features each staff member can access.

## Features

### 1. **Two Types of Access**
- **Mosque Administrator**: Full access to all features and pages
- **Staff Members**: Limited access based on assigned permissions

### 2. **Authentication System**
- **Admin/Mosque Login**: Use email address and password
- **Staff Login**: Use username and password

## How to Use

### For System Administrators

#### Adding a New Mosque
1. Login as admin using email and password
2. Go to "Manage Mosques" section
3. Create a new mosque with credentials
4. The mosque will have full administrator access

### For Mosque Administrators

#### Adding Staff Members
1. Login to your mosque account
2. Navigate to **Staff Management** from the sidebar
3. Click "Add Staff Member"
4. Fill in the staff details:
   - **Name**: Full name of the staff member
   - **Username**: Unique username for login (e.g., "santha_staff")
   - **Password**: Secure password (minimum 6 characters)
   - **Email**: Email address (optional)
   - **Phone**: Contact number (optional)
   - **Role**: Choose either:
     - **Administrator**: Full access to all mosque features
     - **Staff**: Limited access based on permissions
   - **Status**: Active or Inactive

5. If role is **Staff**, select permissions:
   - Dashboard
   - Santha Management
   - Student Management
   - Donation Management
   - Porridge Management
   - Imam Management
   - Ustad Management
   - Prayer Schedule
   - Family Management
   - Mosque Settings
   - Reports & Analytics

6. Click "Create Staff Member"

#### Managing Staff Permissions
1. Go to **Staff Management**
2. Click the edit icon next to any staff member
3. Update their role or permissions
4. Save changes

#### Activating/Deactivating Staff
- Click the status badge to toggle between Active/Inactive
- Inactive staff cannot login

#### Deleting Staff
- Click the delete icon to remove a staff member
- Confirm the action

### For Staff Members

#### Logging In
1. Go to the login page
2. Enter your **username** (not email)
3. Enter your password
4. Click Login

#### Accessing Features
- You will only see menu items for features you have permission to access
- Attempting to access unauthorized pages will redirect you to the dashboard

## Sample Staff Accounts

The system includes sample staff accounts for testing:

1. **Mosque Administrator**
   - Username: `admin123`
   - Password: `password`
   - Access: Full access to all features

2. **Santha Collector**
   - Username: `santha_staff`
   - Password: `password`
   - Access: Dashboard and Santha Collection only

3. **Donation Manager**
   - Username: `donation_staff`
   - Password: `password`
   - Access: Dashboard and Donations only

## Permission Mapping

Each permission controls access to specific pages:

| Permission | Pages/Features Accessible |
|-----------|--------------------------|
| dashboard | Main dashboard view |
| santha | Santha collection management |
| students | Madrasa student management |
| donations | Donation tracking and management |
| porridge | Ramadan porridge distribution |
| imam | Imam management and scheduling |
| ustad | Ustad management |
| prayer_schedule | Prayer times configuration |
| families | Family and member management |
| settings | Mosque settings (includes staff management) |
| reports | Reports and analytics |

## Security Features

1. **Password Hashing**: All passwords are automatically hashed
2. **Session Management**: Separate sessions for users and staff
3. **Active Status Check**: Inactive staff are automatically logged out
4. **Permission Verification**: Each page checks permissions before allowing access
5. **Unique Usernames**: Staff usernames must be unique across the system

## Technical Details

### Database Tables
- **mosque_staff**: Stores staff member information
- **staff_permissions**: Stores individual permissions for each staff member

### Authentication Guards
- **web**: For admin and mosque users (email login)
- **staff**: For staff members (username login)

### Middleware
- **CheckStaffPermission**: Verifies staff has required permissions
- **CheckRole**: Verifies user role (admin/mosque/staff)

## Best Practices

1. **Administrator Role**: Assign administrator role only to trusted individuals
2. **Unique Usernames**: Use descriptive usernames (e.g., "santha_collector_2024")
3. **Strong Passwords**: Enforce strong passwords for all staff
4. **Regular Review**: Periodically review staff permissions and update as needed
5. **Inactive Accounts**: Deactivate staff accounts instead of deleting when possible
6. **Minimal Permissions**: Give staff only the permissions they need

## Troubleshooting

### Staff Cannot Login
- Verify the account is **Active**
- Check username and password are correct
- Ensure using **username** (not email) for staff login

### Staff Cannot Access a Page
- Check the staff member has the required permission
- Administrators should have access to all pages
- Verify the staff account is active

### Permission Changes Not Working
- Staff may need to logout and login again
- Check that permissions were saved correctly

## Future Enhancements

Potential improvements for future versions:
- Permission groups/roles
- Activity logging for staff actions
- Multi-mosque staff access
- Time-based access restrictions
- API access for mobile apps
