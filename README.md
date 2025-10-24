# 🎓 OJT / Internship Placement and Progress Tracking System

<div align="center">

**A comprehensive web-based platform for The College of Maasin**

*Streamlining internship management and monitoring for the modern educational landscape*

---

![Status](https://img.shields.io/badge/status-active-success.svg)
![Platform](https://img.shields.io/badge/platform-web-blue.svg)
![License](https://img.shields.io/badge/license-proprietary-red.svg)

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Key Features](#-key-features)
- [Core Functionality](#-core-functionality)
- [Security Features](#-security-features)
- [System Benefits](#-system-benefits)
- [Technical Requirements](#-technical-requirements)
- [Getting Started](#-getting-started)
- [Support](#-support)

---

## 🌟 Overview

This system bridges the gap between academic theory and real-world practice by providing a centralized digital platform for managing internship placements, tracking student progress, and facilitating communication between administrators, faculty advisers, company supervisors, and students.

### 🎯 Mission
To transform the way The College of Maasin manages OJT programs through sustainable and scalable digital infrastructure, minimizing paperwork while maximizing accountability and transparency.

---

## ✨ Key Features

### 👨‍💼 For Administrators

<table>
<tr>
<td width="50%">

**User Management**
- ✅ Add, edit, activate/deactivate adviser accounts
- ✅ Manage company accounts
- ✅ Comprehensive access control

</td>
<td width="50%">

**System Oversight**
- 📊 Monitor all student records
- 🏢 Review company profiles
- 📥 Export capabilities

</td>
</tr>
<tr>
<td>

**Monitoring & Notifications**
- 🔔 Filtered notification system
- 📅 Date-based filtering
- 🔍 System-wide attendance review

</td>
<td>

**Reporting**
- 📈 Comprehensive reports
- 💾 Full data backup
- 📤 Multiple export formats

</td>
</tr>
</table>

### 👨‍🏫 For OJT Advisers

| Feature | Description |
|---------|-------------|
| 🏢 **Account Management** | Create and manage company and trainee accounts with export functionality |
| 📚 **Course Assignment** | Assign students to companies and set required OJT hours |
| 📝 **Journal Monitoring** | Review submissions and impose penalty hours for late entries |
| ⭐ **Performance Tracking** | Access company feedback and ratings (5-star system) |
| 📊 **Report Generation** | Export individual student summaries to PDF or Excel |
| 👤 **Profile Management** | Upload photos and update passwords |

### 🏢 For Company Supervisors

```
┌─────────────────────────────────────────────────────────┐
│  STUDENT MANAGEMENT                                     │
├─────────────────────────────────────────────────────────┤
│  ✓ Access assigned students' profiles                  │
│  ✓ View progress and attendance history                │
│  ✓ Rate students with 5-star system                    │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  ATTENDANCE CONTROL                                     │
├─────────────────────────────────────────────────────────┤
│  📸 QR code-based Time In/Out camera interface         │
│  ✅ Approve/reject attendance appeals                   │
│  ⏰ Handle overtime requests                            │
│  📜 View recent scan history                            │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  TIME SETTINGS CONFIGURATION                            │
├─────────────────────────────────────────────────────────┤
│  📅 Set OJT start dates                                 │
│  🕐 Define daily Time In/Out windows                    │
│  📆 Designate workdays                                  │
│  🔄 Override schedules for specific dates               │
└─────────────────────────────────────────────────────────┘
```

### 👨‍🎓 For Students

> **Personal Dashboard** - Your complete OJT journey in one place

- 📱 **QR Code Attendance** - Scan for Time In, Time Out, and overtime with photo capture
- 📔 **Daily Journal** - Submit and download daily journal entries
- 📧 **Appeals & Requests** - File attendance appeals and overtime requests
- ⭐ **Feedback Access** - View company ratings and feedback
- 🎓 **Completion Certificate** - Preview and generate certificates upon completion

---

## 🔧 Core Functionality

### 📱 QR Code-Based Attendance

```
Student → Scan QR Code → Photo Capture → Timestamp Logged → Supervisor Review
```

**Features:**
- ⏱️ Automatic timestamp logging
- 📸 Photo verification
- 🕐 Time In, Time Out, and Overtime tracking
- 📜 Recent scan history display
- 📝 Appeals system for concerns

### 📝 Journal Management

| Component | Details |
|-----------|---------|
| **Submission** | Daily journal entry submissions through the system |
| **Storage** | Downloadable journal records for offline access |
| **Penalties** | Automated penalty system for late submissions |
| **Tracking** | Real-time progress monitoring by advisers |

### 🔄 Appeal System

```mermaid
Student Files Appeal → Supervisor Reviews → Approve (with hours) OR Reject (with reason) → Student Notified
```

**Key Points:**
- ✅ Student-initiated attendance appeals
- 👁️ Supervisor review and approval workflow
- 📝 Documented reasons for all decisions
- ⏰ Specified hours adjustment capability

### ⚙️ Time Configuration

<div align="center">

| Setting | Description |
|:-------:|:------------|
| 🗓️ **Schedule** | Flexible per-company settings |
| 🕐 **Windows** | Daily Time In/Out ranges |
| 📅 **Workdays** | Designated working days |
| 🔄 **Overrides** | Date-specific exceptions |

</div>

### 📊 Reporting & Analytics

**Export Formats:** PDF • Excel • CSV

- 📈 Individual student summary reports
- 📉 Comprehensive attendance tracking
- 💡 Data-driven insights for decision-making
- 🎯 Progress monitoring dashboards

---

## 🔒 Security Features

### 🛡️ Role-Based Access Control

<table>
<tr>
<th>Role</th>
<th>Access Level</th>
</tr>
<tr>
<td>👨‍💼 <strong>Administrators</strong></td>
<td>Full system access with user management capabilities</td>
</tr>
<tr>
<td>👨‍🏫 <strong>Faculty Advisers</strong></td>
<td>Access limited to assigned students and related data</td>
</tr>
<tr>
<td>🏢 <strong>Company Supervisors</strong></td>
<td>Restricted to managing assigned trainees only</td>
</tr>
<tr>
<td>👨‍🎓 <strong>Students</strong></td>
<td>Personal dashboard with own data access</td>
</tr>
</table>

### 🔐 Data Privacy

- 🔑 Secure user authentication
- 👁️ Role-specific data visibility
- 🚦 Account activation/deactivation controls
- 💾 Data backup and recovery capabilities

---

## 💎 System Benefits

<div align="center">

### Why Choose This System?

</div>

| Benefit | Impact |
|---------|--------|
| ⚡ **Efficiency** | Eliminates manual paperwork and automates tracking |
| 🎯 **Accuracy** | Photo-verified logs and digital timestamps |
| 🌐 **Transparency** | Centralized access and clear workflows |
| 📱 **Accessibility** | Web-based platform accessible anywhere |

**ROI Highlights:**
- 📉 Reduced administrative workload by up to 70%
- ⏱️ Real-time progress monitoring
- 📊 Automated penalty calculations
- 🔍 Complete audit trail for compliance

---

## 💻 Technical Requirements

### 🌐 Recommended Browser Support

<div align="center">

![Chrome](https://img.shields.io/badge/Chrome-latest-success?logo=google-chrome)
![Firefox](https://img.shields.io/badge/Firefox-latest-orange?logo=firefox)
![Safari](https://img.shields.io/badge/Safari-latest-blue?logo=safari)
![Edge](https://img.shields.io/badge/Edge-latest-informational?logo=microsoft-edge)

</div>

### 📱 Device Compatibility

- 🖥️ Desktop computers
- 💻 Laptops
- 📱 Tablets
- 📲 Smartphones (for QR code scanning)

---

## 🚀 Getting Started

### Quick Start Guide

```
1️⃣ Administrator Setup
   └─ Configure initial system settings and create user accounts

2️⃣ Company Registration
   └─ Add company profiles with contact information and time settings

3️⃣ Student Assignment
   └─ Link students to companies and set required OJT hours

4️⃣ QR Code Distribution
   └─ Provide students with unique QR codes for attendance

5️⃣ Daily Operations
   └─ Students scan QR codes, submit journals, and track progress

6️⃣ Monitoring
   └─ Advisers and supervisors review submissions and provide feedback

7️⃣ Completion
   └─ Generate certificates upon meeting all requirements
```

---

## 📞 Support

<div align="center">

**Need Help?**

For technical support or inquiries about the system, please contact:

📧 **OJT Coordination Office**  
🏫 **The College of Maasin**

</div>

---

## 🔮 Future Enhancements

This system is designed with **scalability** in mind, allowing for future innovations and feature additions as the institution's needs evolve.

**Potential Roadmap:**
- 📊 Advanced analytics and reporting dashboards
- 🤖 AI-powered journal analysis
- 📱 Mobile application development
- 🔗 Integration with learning management systems
- 🌍 Multi-language support

---

<div align="center">

### 🎓 The College of Maasin

**Preparing students effectively for the professional world**

---

Made with ❤️ for academic excellence

[![Back to Top](https://img.shields.io/badge/Back%20to%20Top-↑-blue)](#-ojt--internship-placement-and-progress-tracking-system)

</div>
