import { ColumnDef } from "@tanstack/react-table";

export interface MembershipApplication {
    id: number;
    userId: number;
    membershipId: number;
    formData?: Record<string, any>;
    amount: number;
    paymentStatus: "Pending" | "Paid" | "Failed";
    applicationStatus: "Pending" | "Approved" | "Rejected";
    canResubmit: boolean;
    createdAt: string;
    updatedAt: string;
}

export interface UseTableMembershipApplicationsProps {
    applications: MembershipApplication[];
    columns: ColumnDef<MembershipApplication>[];
}




export interface Email {
  id: string;
  sender: string;
  senderEmail: string;
  subject: string;
  preview: string;
  content: string;
  timestamp: Date;
  read: boolean;
  folder: 'inbox' | 'sent' | 'drafts' | 'trash';
  attachments?: string[];
}

export const mockEmails: Email[] = [
  {
    id: '1',
    sender: 'Sarah Johnson',
    senderEmail: 'sarah.johnson@company.com',
    subject: 'Project Update - Q4 Marketing Campaign',
    preview: 'Hi team, I wanted to provide an update on our Q4 marketing campaign progress...',
    content: `Hi team,

I wanted to provide an update on our Q4 marketing campaign progress. We've made significant strides in the past week:

• Campaign creatives are 90% complete
• Budget allocation has been finalized
• Target audience segments have been refined based on recent analytics
• Launch date confirmed for November 15th

The creative team has delivered some outstanding work, and I'm confident this campaign will exceed our engagement targets. Please review the attached materials and provide feedback by Friday.

Next steps:
1. Final creative approval from stakeholders
2. Media buying confirmation
3. Landing page optimization
4. Analytics tracking setup

Looking forward to your thoughts!

Best regards,
Sarah`,
    timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
    read: false,
    folder: 'inbox',
    attachments: ['Campaign_Overview.pdf', 'Creative_Assets.zip']
  },
  {
    id: '2',
    sender: 'Netflix',
    senderEmail: 'noreply@netflix.com',
    subject: 'New releases this week you might like',
    preview: 'Based on your viewing history, we think you\'ll love these new additions...',
    content: `Hi there!

Based on your viewing history, we think you'll love these new additions to Netflix this week:

🎬 Featured This Week:
• "The Crown" - Season 6 (Drama)
• "Stranger Things: Behind the Scenes" (Documentary)
• "Chef's Table: Noodles" (Food & Travel)
• "Wednesday" - New Episodes (Comedy-Horror)

🔥 Trending Now:
• "The Night Agent" - Action thriller that's taking the world by storm
• "Ginny & Georgia" - Season 2 now available
• "You" - Final season premieres this Friday

Don't forget to add these to your list so you don't miss out!

Happy watching,
The Netflix Team`,
    timestamp: new Date(Date.now() - 4 * 60 * 60 * 1000), // 4 hours ago
    read: false,
    folder: 'inbox'
  },
  {
    id: '3',
    sender: 'GitHub',
    senderEmail: 'noreply@github.com',
    subject: '[Security Alert] New sign-in from Chrome on Mac',
    preview: 'We noticed a new sign-in to your account from a Chrome browser on Mac...',
    content: `Hi there,

We noticed a new sign-in to your GitHub account.

📍 Sign-in details:
• Device: Chrome on Mac
• Location: San Francisco, CA, US
• Time: Today at 2:30 PM PST
• IP Address: 192.168.1.1

If this was you, you can safely ignore this email. If this wasn't you, please:

1. Change your password immediately
2. Review your account activity
3. Enable two-factor authentication
4. Check for any unauthorized changes to your repositories

You can review all recent activity in your account settings.

Stay secure,
The GitHub Security Team`,
    timestamp: new Date(Date.now() - 6 * 60 * 60 * 1000), // 6 hours ago
    read: true,
    folder: 'inbox'
  },
  {
    id: '4',
    sender: 'Michael Chen',
    senderEmail: 'm.chen@techcorp.com',
    subject: 'Re: Weekly Team Sync - Tomorrow at 2 PM',
    preview: 'Thanks for scheduling this. I\'ve added the meeting to my calendar...',
    content: `Hi everyone,

Thanks for scheduling this. I've added the meeting to my calendar and prepared the following agenda items:

📋 Agenda:
1. Sprint retrospective (15 min)
2. Current project status updates (20 min)
3. Upcoming deadlines and deliverables (10 min)
4. Resource allocation for next sprint (10 min)
5. Q&A and open discussion (5 min)

I'll be sharing my screen to walk through our current dashboard metrics and the latest performance reports.

Please come prepared with:
• Your individual progress updates
• Any blockers you're currently facing
• Resource requests for the upcoming sprint

Looking forward to a productive discussion tomorrow!

Best,
Michael`,
    timestamp: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000), // 1 day ago
    read: false,
    folder: 'inbox'
  },
  {
    id: '5',
    sender: 'LinkedIn',
    senderEmail: 'messages-noreply@linkedin.com',
    subject: 'Your weekly network update',
    preview: 'See what your connections have been up to this week...',
    content: `Hi there!

See what your connections have been up to this week:

🎉 Congratulations are in order:
• Alex Rodriguez started a new position as Senior Developer at Meta
• Jessica Wu received a promotion to Product Manager at Spotify
• David Kim celebrated 5 years at Google

📈 Industry insights from your network:
• "The Future of AI in Software Development" - Article by Sarah Thompson
• "Remote Work Best Practices for 2024" - Post by Jennifer Martinez
• "Startup Funding Trends This Quarter" - Update from venture capitalist Mark Johnson

👥 People you may know:
• Emma Wilson (Product Designer at Adobe)
• Robert Chang (Engineering Manager at Airbnb)
• Lisa Park (Data Scientist at Tesla)

Stay connected and keep growing your professional network!

Best regards,
The LinkedIn Team`,
    timestamp: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000), // 2 days ago
    read: true,
    folder: 'inbox'
  },
  {
    id: '6',
    sender: 'You',
    senderEmail: 'me@example.com',
    subject: 'Meeting follow-up with client',
    preview: 'Thank you for taking the time to meet with us today...',
    content: `Dear Mr. Anderson,

Thank you for taking the time to meet with us today to discuss your upcoming project requirements. It was great to learn more about your vision and goals.

As discussed, here's a summary of what we covered:

• Project timeline: 3-month development cycle
• Budget range: $50k - $75k
• Key features: User dashboard, analytics, mobile responsiveness
• Technology stack: React, Node.js, PostgreSQL
• Launch target: Q1 2024

Next steps:
1. I'll send over a detailed proposal by Friday
2. We'll schedule a technical deep-dive session next week
3. Contract review and signing by month-end

Please don't hesitate to reach out if you have any questions or concerns.

Best regards,
[Your Name]`,
    timestamp: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000), // 3 days ago
    read: true,
    folder: 'sent'
  },
  {
    id: '7',
    sender: 'Draft',
    senderEmail: 'draft@example.com',
    subject: 'Annual performance review preparation',
    preview: 'Notes for upcoming performance review meeting...',
    content: `Annual Performance Review - Self Assessment Draft

Key Accomplishments This Year:
• Led successful migration of legacy system to microservices architecture
• Mentored 3 junior developers, all received promotions
• Reduced system downtime by 40% through proactive monitoring
• Delivered 5 major features ahead of schedule

Areas for Growth:
• Public speaking and presentation skills
• Cross-functional collaboration
• Technical leadership in larger teams

Goals for Next Year:
• Obtain AWS Solutions Architect certification
• Lead a team of 8+ developers
• Contribute to open source projects
• Present at industry conferences

Questions to discuss:
• Career progression opportunities
• Budget for professional development
• Remote work arrangements
• Salary adjustment considerations`,
    timestamp: new Date(Date.now() - 4 * 24 * 60 * 60 * 1000), // 4 days ago
    read: false,
    folder: 'drafts'
  },
    {
    id: '1',
    sender: 'Sarah Johnson',
    senderEmail: 'sarah.johnson@company.com',
    subject: 'Project Update - Q4 Marketing Campaign',
    preview: 'Hi team, I wanted to provide an update on our Q4 marketing campaign progress...',
    content: `Hi team,

I wanted to provide an update on our Q4 marketing campaign progress. We've made significant strides in the past week:

• Campaign creatives are 90% complete
• Budget allocation has been finalized
• Target audience segments have been refined based on recent analytics
• Launch date confirmed for November 15th

The creative team has delivered some outstanding work, and I'm confident this campaign will exceed our engagement targets. Please review the attached materials and provide feedback by Friday.

Next steps:
1. Final creative approval from stakeholders
2. Media buying confirmation
3. Landing page optimization
4. Analytics tracking setup

Looking forward to your thoughts!

Best regards,
Sarah`,
    timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
    read: false,
    folder: 'inbox',
    attachments: ['Campaign_Overview.pdf', 'Creative_Assets.zip']
  },
  {
    id: '2',
    sender: 'Netflix',
    senderEmail: 'noreply@netflix.com',
    subject: 'New releases this week you might like',
    preview: 'Based on your viewing history, we think you\'ll love these new additions...',
    content: `Hi there!

Based on your viewing history, we think you'll love these new additions to Netflix this week:

🎬 Featured This Week:
• "The Crown" - Season 6 (Drama)
• "Stranger Things: Behind the Scenes" (Documentary)
• "Chef's Table: Noodles" (Food & Travel)
• "Wednesday" - New Episodes (Comedy-Horror)

🔥 Trending Now:
• "The Night Agent" - Action thriller that's taking the world by storm
• "Ginny & Georgia" - Season 2 now available
• "You" - Final season premieres this Friday

Don't forget to add these to your list so you don't miss out!

Happy watching,
The Netflix Team`,
    timestamp: new Date(Date.now() - 4 * 60 * 60 * 1000), // 4 hours ago
    read: false,
    folder: 'inbox'
  },
  {
    id: '3',
    sender: 'GitHub',
    senderEmail: 'noreply@github.com',
    subject: '[Security Alert] New sign-in from Chrome on Mac',
    preview: 'We noticed a new sign-in to your account from a Chrome browser on Mac...',
    content: `Hi there,

We noticed a new sign-in to your GitHub account.

📍 Sign-in details:
• Device: Chrome on Mac
• Location: San Francisco, CA, US
• Time: Today at 2:30 PM PST
• IP Address: 192.168.1.1

If this was you, you can safely ignore this email. If this wasn't you, please:

1. Change your password immediately
2. Review your account activity
3. Enable two-factor authentication
4. Check for any unauthorized changes to your repositories

You can review all recent activity in your account settings.

Stay secure,
The GitHub Security Team`,
    timestamp: new Date(Date.now() - 6 * 60 * 60 * 1000), // 6 hours ago
    read: true,
    folder: 'inbox'
  },
  {
    id: '4',
    sender: 'Michael Chen',
    senderEmail: 'm.chen@techcorp.com',
    subject: 'Re: Weekly Team Sync - Tomorrow at 2 PM',
    preview: 'Thanks for scheduling this. I\'ve added the meeting to my calendar...',
    content: `Hi everyone,

Thanks for scheduling this. I've added the meeting to my calendar and prepared the following agenda items:

📋 Agenda:
1. Sprint retrospective (15 min)
2. Current project status updates (20 min)
3. Upcoming deadlines and deliverables (10 min)
4. Resource allocation for next sprint (10 min)
5. Q&A and open discussion (5 min)

I'll be sharing my screen to walk through our current dashboard metrics and the latest performance reports.

Please come prepared with:
• Your individual progress updates
• Any blockers you're currently facing
• Resource requests for the upcoming sprint

Looking forward to a productive discussion tomorrow!

Best,
Michael`,
    timestamp: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000), // 1 day ago
    read: false,
    folder: 'inbox'
  },
  {
    id: '5',
    sender: 'LinkedIn',
    senderEmail: 'messages-noreply@linkedin.com',
    subject: 'Your weekly network update',
    preview: 'See what your connections have been up to this week...',
    content: `Hi there!

See what your connections have been up to this week:

🎉 Congratulations are in order:
• Alex Rodriguez started a new position as Senior Developer at Meta
• Jessica Wu received a promotion to Product Manager at Spotify
• David Kim celebrated 5 years at Google

📈 Industry insights from your network:
• "The Future of AI in Software Development" - Article by Sarah Thompson
• "Remote Work Best Practices for 2024" - Post by Jennifer Martinez
• "Startup Funding Trends This Quarter" - Update from venture capitalist Mark Johnson

👥 People you may know:
• Emma Wilson (Product Designer at Adobe)
• Robert Chang (Engineering Manager at Airbnb)
• Lisa Park (Data Scientist at Tesla)

Stay connected and keep growing your professional network!

Best regards,
The LinkedIn Team`,
    timestamp: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000), // 2 days ago
    read: true,
    folder: 'inbox'
  },
  {
    id: '6',
    sender: 'You',
    senderEmail: 'me@example.com',
    subject: 'Meeting follow-up with client',
    preview: 'Thank you for taking the time to meet with us today...',
    content: `Dear Mr. Anderson,

Thank you for taking the time to meet with us today to discuss your upcoming project requirements. It was great to learn more about your vision and goals.

As discussed, here's a summary of what we covered:

• Project timeline: 3-month development cycle
• Budget range: $50k - $75k
• Key features: User dashboard, analytics, mobile responsiveness
• Technology stack: React, Node.js, PostgreSQL
• Launch target: Q1 2024

Next steps:
1. I'll send over a detailed proposal by Friday
2. We'll schedule a technical deep-dive session next week
3. Contract review and signing by month-end

Please don't hesitate to reach out if you have any questions or concerns.

Best regards,
[Your Name]`,
    timestamp: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000), // 3 days ago
    read: true,
    folder: 'sent'
  },
  {
    id: '7',
    sender: 'Draft',
    senderEmail: 'draft@example.com',
    subject: 'Annual performance review preparation',
    preview: 'Notes for upcoming performance review meeting...',
    content: `Annual Performance Review - Self Assessment Draft

Key Accomplishments This Year:
• Led successful migration of legacy system to microservices architecture
• Mentored 3 junior developers, all received promotions
• Reduced system downtime by 40% through proactive monitoring
• Delivered 5 major features ahead of schedule

Areas for Growth:
• Public speaking and presentation skills
• Cross-functional collaboration
• Technical leadership in larger teams

Goals for Next Year:
• Obtain AWS Solutions Architect certification
• Lead a team of 8+ developers
• Contribute to open source projects
• Present at industry conferences

Questions to discuss:
• Career progression opportunities
• Budget for professional development
• Remote work arrangements
• Salary adjustment considerations`,
    timestamp: new Date(Date.now() - 4 * 24 * 60 * 60 * 1000), // 4 days ago
    read: false,
    folder: 'drafts'
  },
    {
    id: '1',
    sender: 'Sarah Johnson',
    senderEmail: 'sarah.johnson@company.com',
    subject: 'Project Update - Q4 Marketing Campaign',
    preview: 'Hi team, I wanted to provide an update on our Q4 marketing campaign progress...',
    content: `Hi team,

I wanted to provide an update on our Q4 marketing campaign progress. We've made significant strides in the past week:

• Campaign creatives are 90% complete
• Budget allocation has been finalized
• Target audience segments have been refined based on recent analytics
• Launch date confirmed for November 15th

The creative team has delivered some outstanding work, and I'm confident this campaign will exceed our engagement targets. Please review the attached materials and provide feedback by Friday.

Next steps:
1. Final creative approval from stakeholders
2. Media buying confirmation
3. Landing page optimization
4. Analytics tracking setup

Looking forward to your thoughts!

Best regards,
Sarah`,
    timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
    read: false,
    folder: 'inbox',
    attachments: ['Campaign_Overview.pdf', 'Creative_Assets.zip']
  },
  {
    id: '2',
    sender: 'Netflix',
    senderEmail: 'noreply@netflix.com',
    subject: 'New releases this week you might like',
    preview: 'Based on your viewing history, we think you\'ll love these new additions...',
    content: `Hi there!

Based on your viewing history, we think you'll love these new additions to Netflix this week:

🎬 Featured This Week:
• "The Crown" - Season 6 (Drama)
• "Stranger Things: Behind the Scenes" (Documentary)
• "Chef's Table: Noodles" (Food & Travel)
• "Wednesday" - New Episodes (Comedy-Horror)

🔥 Trending Now:
• "The Night Agent" - Action thriller that's taking the world by storm
• "Ginny & Georgia" - Season 2 now available
• "You" - Final season premieres this Friday

Don't forget to add these to your list so you don't miss out!

Happy watching,
The Netflix Team`,
    timestamp: new Date(Date.now() - 4 * 60 * 60 * 1000), // 4 hours ago
    read: false,
    folder: 'inbox'
  },
  {
    id: '3',
    sender: 'GitHub',
    senderEmail: 'noreply@github.com',
    subject: '[Security Alert] New sign-in from Chrome on Mac',
    preview: 'We noticed a new sign-in to your account from a Chrome browser on Mac...',
    content: `Hi there,

We noticed a new sign-in to your GitHub account.

📍 Sign-in details:
• Device: Chrome on Mac
• Location: San Francisco, CA, US
• Time: Today at 2:30 PM PST
• IP Address: 192.168.1.1

If this was you, you can safely ignore this email. If this wasn't you, please:

1. Change your password immediately
2. Review your account activity
3. Enable two-factor authentication
4. Check for any unauthorized changes to your repositories

You can review all recent activity in your account settings.

Stay secure,
The GitHub Security Team`,
    timestamp: new Date(Date.now() - 6 * 60 * 60 * 1000), // 6 hours ago
    read: true,
    folder: 'inbox'
  },
  {
    id: '4',
    sender: 'Michael Chen',
    senderEmail: 'm.chen@techcorp.com',
    subject: 'Re: Weekly Team Sync - Tomorrow at 2 PM',
    preview: 'Thanks for scheduling this. I\'ve added the meeting to my calendar...',
    content: `Hi everyone,

Thanks for scheduling this. I've added the meeting to my calendar and prepared the following agenda items:

📋 Agenda:
1. Sprint retrospective (15 min)
2. Current project status updates (20 min)
3. Upcoming deadlines and deliverables (10 min)
4. Resource allocation for next sprint (10 min)
5. Q&A and open discussion (5 min)

I'll be sharing my screen to walk through our current dashboard metrics and the latest performance reports.

Please come prepared with:
• Your individual progress updates
• Any blockers you're currently facing
• Resource requests for the upcoming sprint

Looking forward to a productive discussion tomorrow!

Best,
Michael`,
    timestamp: new Date(Date.now() - 1 * 24 * 60 * 60 * 1000), // 1 day ago
    read: false,
    folder: 'inbox'
  },
  {
    id: '5',
    sender: 'LinkedIn',
    senderEmail: 'messages-noreply@linkedin.com',
    subject: 'Your weekly network update',
    preview: 'See what your connections have been up to this week...',
    content: `Hi there!

See what your connections have been up to this week:

🎉 Congratulations are in order:
• Alex Rodriguez started a new position as Senior Developer at Meta
• Jessica Wu received a promotion to Product Manager at Spotify
• David Kim celebrated 5 years at Google

📈 Industry insights from your network:
• "The Future of AI in Software Development" - Article by Sarah Thompson
• "Remote Work Best Practices for 2024" - Post by Jennifer Martinez
• "Startup Funding Trends This Quarter" - Update from venture capitalist Mark Johnson

👥 People you may know:
• Emma Wilson (Product Designer at Adobe)
• Robert Chang (Engineering Manager at Airbnb)
• Lisa Park (Data Scientist at Tesla)

Stay connected and keep growing your professional network!

Best regards,
The LinkedIn Team`,
    timestamp: new Date(Date.now() - 2 * 24 * 60 * 60 * 1000), // 2 days ago
    read: true,
    folder: 'inbox'
  },
  {
    id: '6',
    sender: 'You',
    senderEmail: 'me@example.com',
    subject: 'Meeting follow-up with client',
    preview: 'Thank you for taking the time to meet with us today...',
    content: `Dear Mr. Anderson,

Thank you for taking the time to meet with us today to discuss your upcoming project requirements. It was great to learn more about your vision and goals.

As discussed, here's a summary of what we covered:

• Project timeline: 3-month development cycle
• Budget range: $50k - $75k
• Key features: User dashboard, analytics, mobile responsiveness
• Technology stack: React, Node.js, PostgreSQL
• Launch target: Q1 2024

Next steps:
1. I'll send over a detailed proposal by Friday
2. We'll schedule a technical deep-dive session next week
3. Contract review and signing by month-end

Please don't hesitate to reach out if you have any questions or concerns.

Best regards,
[Your Name]`,
    timestamp: new Date(Date.now() - 3 * 24 * 60 * 60 * 1000), // 3 days ago
    read: true,
    folder: 'sent'
  },
  {
    id: '7',
    sender: 'Draft',
    senderEmail: 'draft@example.com',
    subject: 'Annual performance review preparation',
    preview: 'Notes for upcoming performance review meeting...',
    content: `Annual Performance Review - Self Assessment Draft

Key Accomplishments This Year:
• Led successful migration of legacy system to microservices architecture
• Mentored 3 junior developers, all received promotions
• Reduced system downtime by 40% through proactive monitoring
• Delivered 5 major features ahead of schedule

Areas for Growth:
• Public speaking and presentation skills
• Cross-functional collaboration
• Technical leadership in larger teams

Goals for Next Year:
• Obtain AWS Solutions Architect certification
• Lead a team of 8+ developers
• Contribute to open source projects
• Present at industry conferences

Questions to discuss:
• Career progression opportunities
• Budget for professional development
• Remote work arrangements
• Salary adjustment considerations`,
    timestamp: new Date(Date.now() - 4 * 24 * 60 * 60 * 1000), // 4 days ago
    read: false,
    folder: 'drafts'
  }


];
