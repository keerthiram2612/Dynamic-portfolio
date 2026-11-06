import { useEffect, useState } from "react";
import "./Home.css";

const API_URL = "http://127.0.0.1:8000/api";

export default function Home() {
    const [profile, setProfile] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetch(`${API_URL}/profile`)
            .then((res) => {
                if (!res.ok) throw new Error(`Request failed: ${res.status}`);
                return res.json();
            })
            .then(setProfile)
            .catch((err) => setError(err.message))
            .finally(() => setLoading(false));
    }, []);

    if (loading) return <p className="status">Loading...</p>;
    if (error) return <p className="status error">Error: {error}</p>;
    if (!profile) return null;

    const stack =
        typeof profile.stack === "string" ? JSON.parse(profile.stack) : profile.stack || [];

    return (
        <main className="home">
            <section className="hero">
                {profile.available ? (
                    <span className="badge">● Available for work</span>
                ) : (
                    <span className="badge off">● Currently unavailable</span>
                )}

                <h1>
                    Hi, I'm <span className="accent">{profile.name}</span>
                </h1>
                <h2>{profile.role}</h2>
                <p className="tagline">{profile.tagline}</p>

                <a className="btn" href={`mailto:${profile.email}`}>
                    Contact me
                </a>
            </section>

            <section className="card">
                <h3>About</h3>
                <p>{profile.about}</p>
            </section>

            <section className="card">
                <h3>Tech Stack</h3>
                <ul className="stack">
                    {stack.map((tech) => (
                        <li key={tech}>{tech}</li>
                    ))}
                </ul>
            </section>

            <footer className="footer">
                <a href={`mailto:${profile.email}`}>{profile.email}</a>
            </footer>
        </main>
    );
}