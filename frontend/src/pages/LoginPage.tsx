import { useState } from "react";
import api from "../api/axios";

export default function LoginPage() {

    const [email, setEmail] =
        useState("");

    const [password, setPassword] =
        useState("");

    async function handleSubmit(
        e: React.FormEvent
    ) {

        e.preventDefault();

        try {

            const response =
                await api.post(
                    "/login",
                    {
                        email,
                        password
                    }
                );

            console.log(
                response.data
            );

            localStorage.setItem(
                "token",
                response.data.token
            );

            window.location.href =
                "/tickets";

        } catch (error) {

            console.error(error);

            alert(
                "Credenciais inválidas"
            );
        }
    }

    return (
        <div>

            <h1>
                Login
            </h1>

            <form
                onSubmit={handleSubmit}
            >

                <div>

                    <input
                        type="email"
                        placeholder="Email"
                        value={email}
                        onChange={(e) =>
                            setEmail(
                                e.target.value
                            )
                        }
                    />

                </div>

                <div>

                    <input
                        type="password"
                        placeholder="Senha"
                        value={password}
                        onChange={(e) =>
                            setPassword(
                                e.target.value
                            )
                        }
                    />

                </div>

                <button
                    type="submit"
                >
                    Entrar
                </button>

            </form>

        </div>
    );
}