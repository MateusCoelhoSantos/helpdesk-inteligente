import {
    BrowserRouter,
    Routes,
    Route
} from "react-router-dom";

import LoginPage from "../pages/LoginPage";
import TicketsPage from "../pages/TicketsPage";
import TicketDetailsPage
    from "../pages/TicketDetailsPage";

export default function AppRoutes() {

    return (

        <BrowserRouter>

            <Routes>

                <Route
                    path="/"
                    element={
                        <LoginPage />
                    }
                />

                <Route
                    path="/tickets"
                    element={
                        <TicketsPage />
                    }
                />

                <Route
                    path="/tickets/:id"
                    element={
                        <TicketDetailsPage />
                    }
                />

            </Routes>

        </BrowserRouter>

    );
}