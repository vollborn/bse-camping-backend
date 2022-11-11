DROP TABLE IF EXISTS additional_cost_pitch;

CREATE TABLE additional_cost_pitch (
    pitch_id INT NOT NULL,
    additional_cost_id INT NOT NULL,

    PRIMARY KEY (pitch_id, additional_cost_id),

    FOREIGN KEY (pitch_id) REFERENCES pitches(id),
    FOREIGN KEY (additional_cost_id) REFERENCES additional_costs(id)
);
