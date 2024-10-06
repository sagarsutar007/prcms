require("dotenv").config();

const express = require("express");
const helmet = require("helmet");
const cors = require("cors");
const compression = require("compression");
const app = express();
const port = 3000;
const authRouter = require("./routes/authRouter");
const candidateRouter = require("./routes/candidateRouter");
const businessRouter = require("./routes/businessRouter");
const examRouter = require("./routes/examRouter");

// Use Helmet for security
app.use(helmet());

// Disable 'X-Powered-By' header
app.disable("x-powered-by");

// Enable CORS
const corsOptions = {
  origin: 'http://192.168.31.24:5173',
  methods: ['GET', 'POST', 'PUT', 'DELETE'],
  allowedHeaders: ['Content-Type', 'x-auth-token'],
  credentials: true,
};
app.use(cors(corsOptions));


app.use(compression());
app.use(express.json());
app.use("/api", authRouter);
app.use("/api", candidateRouter);
app.use("/api", businessRouter);
app.use("/api", examRouter);

app.get("/", (req, res) => {
	res.send("Hello World!");
});

app.listen(port, () => {
	console.log(`Server is running on http://localhost:${port}`);
});
