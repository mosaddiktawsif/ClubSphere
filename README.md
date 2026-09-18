<div align="center">

# 🎮 ClubSphere - Esports Club Management System

  <p><b>A web-based MVC application designed to centralize and manage university esports club activities, including member registration, team formation, tournament tracking, and financial records.</b></p>

  <p>
    <img src="https://img.shields.io/badge/PHP-7.4%2B%20%7C%208.x-777BB4?style=flat-square&logo=php&logoColor=white" />
    <img src="https://img.shields.io/badge/Architecture-MVC-blue?style=flat-square" />
    <img src="https://img.shields.io/badge/Database-MySQL%20%2F%20PDO-4479A1?style=flat-square&logo=mysql&logoColor=white" />
    <img src="https://img.shields.io/badge/Frontend-HTML5%20%7C%20CSS3%20%7C%20JS-E34F26?style=flat-square&logo=html5&logoColor=white" />
    <img src="https://img.shields.io/badge/Course-CSC%203215%3A%20Web%20Technologies-orange?style=flat-square" />
  </p>
</div>

---

## 📖 About The Project

Managing competitive gaming events and club operations on university campuses currently involves a scattered approach utilizing social media, messaging apps, and spreadsheets. **ClubSphere** solves this by providing a unified, role-based platform to handle all esports activities in one place

Built strictly using the **MVC (Model-View-Controller)** architecture, the system cleanly separates database operations (Models) from the user interface (Views) and logic routing (Controllers). This ensures scalable management of teams, events, and club resources, providing a structured environment tailored specifically for university esports communities.

---

## 🏛️ Academic Context & Team Details

* **Institution:** American International University-Bangladesh (AIUB)
* **Faculty:** Faculty of Science and Technology
* **Department:** Department of Computer Science
* **Course:** CSC 3215: Web Technologies
* **Semester:** Summer 2025-26
* **Group No:** 1
* **Section:** F

### Project Team Members
| SL | Student ID | Name | Role |
| :--- | :--- | :--- | :--- |
| 1 | `22-46726-1` | Mosaddik Al Tawsif | Group Leader |
| 2 | `23-51517-1` | MD Tasnim Ul Islam | Member |
| 3 | `22-46057-1` | Rezuanul Islam Fahim | Member |
| 4 | `23-54248-3	`|  ARITRA DEY | Member |

---

## 🛡️ System Features & User Roles

The platform categorizes users into four primary types: **Admin**, **Moderator**, **Team Captain**, and **General Member**.

### 🌐 Common Features (Available to All Users)
* **Authentication:** Login to the system and logout from the system.
* **User Registration:** Register a new account.
* **Account Management:** Change or reset password, and manage profile information (view, edit, delete).
* **Dashboard:** Access a personalized dashboard after login.

### 1. 👑 Administrator Features
* **Membership Approval & Role Assignment:** Exclusively approve or reject incoming membership requests and assign system roles (Admin, Moderator, Captain, Member) to specific users.
* **Financial Ledger Management:** Record club income (sponsorships, entry fees) and expenses (logistics, equipment), and generate overall club financial summaries.
* **Tournament Creation Engine:** Formulate new events by defining game titles, dates, rulesets, and initializing the automated knockout bracket system.

### 2. 🛡️ Moderator Features
* **Match Result Verification:** Review match outcome screenshots submitted by players and finalize the official scores to update the live leaderboards.
* **Inventory Tracking:** Add new gaming equipment to the database, track which members are using specific items, and update equipment condition statuses.
* **Announcement Broadcasting:** Post global news, event updates, and schedule changes directly to the public announcement board.

### 3. ⚔️ Team Captain Features
* **Roster Assembly & Oversight:** Create a new team entity, invite specific club members to join the roster, and remove inactive players.
* **Tournament Registration Submission:** Select an active tournament and submit the finalized team roster for official event enrollment.
* **Score Proof Submission:** Self-report match outcomes and upload required post-match screenshot evidence into the system for Moderator review.

### 4. 👤 General Member Features
* **Gaming Profile Customization:** Update personal gaming preferences, input current in-game rankings, and link external social media accounts.
* **Team Join Requests:** Browse the list of existing club teams and submit applications to Team Captains to join a competitive roster.
* **Live Bracket & Schedule Tracking:** Access real-time, dynamic views of tournament schedules, knockout brackets, and individual team statistics without administrative edit rights.

---

## 📁 Project Directory Structure

```text
clubsphere/
│
├── Assets/
│   └── css/
│       └── style.css         # Global unified CSS theme & responsive layout rules
│
├── Controllers/
│   ├── AdminController.php   # Handles admin actions (approvals, funds, tournaments)
│   ├── AuthController.php    # Manages login, registration, and session logic
│   ├── MainController.php    # Routes captain and general user workflows
│   ├── ProfileController.php # Manages user profile updates and account deletion
│   ├── auth_guard.php        # Role-based session security and access protection
│   └── database.php          # PDO database connection configuration class
│
├── Model/
│   ├── CaptainModel.php      # Database operations for team rosters and captain functions
│   ├── ClubFund.php          # Financial transaction logs and balance calculators
│   ├── Tournament.php        # Tournament management and bracket filtering queries
│   └── User.php              # User profile, role updates, and authentication queries
│
├── View/
│   ├── admin/
│   │   ├── fund.php          # Admin financial ledger view
│   │   ├── members.php       # Membership request approval & role modifier table
│   │   ├── panel.php         # Admin statistics dashboard
│   │   └── tournaments.php   # Admin tournament generator & status manager
│   ├── partials/
│   │   ├── footer.php        # Reusable footer component
│   │   ├── header.php        # Global HTML header template linking main CSS
│   │   └── sidebar.php       # Dynamic navigation sidebar based on user role
│   ├── captaindashboard.php  # Team captain control panel and score uploader
│   ├── dashboard.php         # Member profile and quick navigation hub
│   ├── edit_profile.php      # Account setting modifications
│   ├── login.php             # Unified portal gateway / Admin login interface
│   ├── register.php          # Member registration interface
│   ├── loginascaptain.php    # Dedicated captain login gateway
│   ├── registerascaptain.php # Dedicated captain registration form
│   ├── rosterinfo.php        # Team roster player management interface
│   └── tournaments_2.php     # Tournament browsing and roster enrollment screen
│
├── index.php                 # Core MVC frontend application router
└── database.sql              # Initial database creation and schema script
