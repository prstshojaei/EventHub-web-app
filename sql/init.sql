-- Create events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME DEFAULT '09:00:00',
    location VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create admins table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add default admin account (username: admin, password: admin123)
INSERT INTO admins (username, password_hash) VALUES (
    'admin',
    '$2y$10$5dZva8xiB9l33KXarv91JecLke1NIf6wOBD8ixaYlLACop.QhxgTi'
);

-- Add sample events
INSERT INTO events (title, date, time, location, category, description) VALUES
('IoT Smart Home Basics', '2026-06-12', '09:00:00', 'Northampton', 'IoT', 'Introduction to sensors, microcontrollers, and smart home systems.'),
('AI for Beginners', '2026-06-20', '10:00:00', 'London', 'AI', 'Basic AI concepts and how AI is used in real applications.'),
('Cybersecurity Workshop', '2026-06-28', '14:00:00', 'Online', 'Cybersecurity', 'Common threats and simple ways to improve security.'),
('Machine Learning with Python', '2026-07-05', '10:00:00', 'Birmingham', 'AI', 'Hands-on session building machine learning models using Python and scikit-learn.'),
('IoT and Smart Cities', '2026-07-12', '09:30:00', 'Manchester', 'IoT', 'How IoT technology is transforming urban infrastructure and city management.'),
('Ethical Hacking Fundamentals', '2026-07-18', '13:00:00', 'Online', 'Cybersecurity', 'Learn the basics of penetration testing and ethical hacking techniques.'),
('Deep Learning Workshop', '2026-07-25', '10:00:00', 'London', 'AI', 'Introduction to neural networks and deep learning using TensorFlow.'),
('IoT in Healthcare', '2026-08-02', '09:00:00', 'Northampton', 'IoT', 'Exploring how IoT devices are revolutionising patient monitoring and healthcare.'),
('Network Security Essentials', '2026-08-10', '14:00:00', 'Birmingham', 'Cybersecurity', 'Understanding firewalls, VPNs, and network security protocols.'),
('Natural Language Processing', '2026-08-18', '10:00:00', 'Online', 'AI', 'Building text analysis and chatbot applications using NLP techniques.'),
('Web Development Bootcamp', '2026-08-25', '09:00:00', 'London', 'Web Development', 'Full-stack web development using HTML, CSS, JavaScript, PHP and MySQL.'),
('Python for Data Science', '2026-09-02', '10:00:00', 'Manchester', 'Data Science', 'Using Python libraries like Pandas, NumPy and Matplotlib for data analysis.'),
('Cloud Computing Fundamentals', '2026-09-10', '14:00:00', 'Online', 'Cloud', 'Introduction to AWS, Azure and Google Cloud platforms.'),
('React JS Workshop', '2026-09-18', '09:30:00', 'Birmingham', 'Web Development', 'Building modern single-page applications using React and hooks.'),
('Data Visualisation with Python', '2026-09-25', '10:00:00', 'Northampton', 'Data Science', 'Creating interactive charts and dashboards using Matplotlib and Seaborn.'),
('Docker and Containers', '2026-10-02', '14:00:00', 'Online', 'Cloud', 'Understanding containerisation and deploying applications with Docker.'),
('Ransomware and Defence', '2026-10-10', '09:00:00', 'London', 'Cybersecurity', 'How ransomware works and how to protect systems from attacks.'),
('IoT Edge Computing', '2026-10-18', '10:00:00', 'Manchester', 'IoT', 'Processing data at the edge using Raspberry Pi and Arduino boards.'),
('AWS Cloud Practitioner', '2026-10-25', '09:00:00', 'Online', 'Cloud', 'Preparing for the AWS Cloud Practitioner certification exam.'),
('Computer Vision Basics', '2026-11-02', '10:00:00', 'London', 'AI', 'Introduction to image recognition and object detection using OpenCV.'),
('API Development with PHP', '2026-11-10', '14:00:00', 'Birmingham', 'Web Development', 'Building RESTful APIs using PHP and MySQL for mobile and web apps.'),
('Big Data Analytics', '2026-11-18', '10:00:00', 'Manchester', 'Data Science', 'Processing and analysing large datasets using Apache Spark and Hadoop.'),
('Penetration Testing Lab', '2026-11-25', '13:00:00', 'Online', 'Cybersecurity', 'Hands-on penetration testing using Kali Linux and Metasploit.'),
('Kubernetes for Beginners', '2026-12-02', '09:00:00', 'London', 'Cloud', 'Managing containerised applications with Kubernetes and Helm.');